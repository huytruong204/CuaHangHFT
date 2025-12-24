<?php
include_once __DIR__ . '/../core/Validator.php';
include_once __DIR__ . '/../core/BaseModel.php';
class OrderModel extends BaseModel
{
    public const TB_NAME = "orders";
    protected $order_id;
    protected $user_id;
    protected $fullname;
    protected $phone_number;
    protected $address;
    protected $shipper_id;
    protected $payment_method;
    protected $payment_status;
    protected $total_money;
    protected $status;
    protected $note;
    protected $created_at;
    public function __construct($data = [])
    {
        parent::__construct(self::TB_NAME);

        if (!empty($data)) {
            $this->order_id        = $data['order_id'] ?? null;
            $this->user_id         = $data['user_id'] ?? null;
            $this->fullname        = $data['fullname'] ?? null;
            $this->phone_number    = $data['phone_number'] ?? null;
            $this->address         = $data['address'] ?? null;
            $this->shipper_id      = $data['shipper_id'] ?? null;
            $this->total_money     = $data['total_money'] ?? null;
            $this->payment_method  = $data['payment_method'] ?? null;
            $this->payment_status  = $data['payment_status'] ?? null;
            $this->status          = $data['status'] ?? null;
            $this->note            = $data['note'] ?? null;
            $this->created_at      = $data['created_at'] ?? null;
        }
    }
    public function getAll($offset, $rows_per_page, $where_clauses, $sort_date = 'desc')
    {
        try {
            $list_orders = [];
            $sql = "SELECT orders.*
                    FROM " . self::TB_NAME;
            $sql_clauses_arr = [];
            $values = [];

            if (!empty($where_clauses)) {
                foreach ($where_clauses as $key => $value) {
                    if ($key === 'search_id') {
                        $sql_clauses_arr[] = "orders.order_id LIKE ?";
                        $values[] = "%$value%";
                    } elseif ($key === 'date_from') {
                        $sql_clauses_arr[] = "DATE(orders.created_at) >= ?";
                        $values[] = $value;
                    } elseif ($key === 'date_to') {
                        $sql_clauses_arr[] = "DATE(orders.created_at) <= ?";
                        $values[] = $value;
                    } else {
                        $sql_clauses_arr[] = "$key = ?";
                        $values[] = $value;
                    }
                }
                $sql .= " WHERE " . implode(" AND ", $sql_clauses_arr);
            }

            $sort_direction = (strtolower($sort_date) === 'asc') ? 'ASC' : 'DESC';
            $sql .= " ORDER BY orders.created_at $sort_direction";

            $sql .= " LIMIT $offset, $rows_per_page";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $value) {
                $value['shipper_id'] = $value['full_name'] ?? $value['shipper_id'];

                $list_orders[] = new OrderModel($value);
            }

            return $list_orders;
        } catch (PDOException $e) {
            $this->error_message = "Lỗi: " . $e->getMessage();
            return [];
        }
    }


    public function getDashboardStats()
    {
        try {
            $stats = [
                'orders_today' => 0,
                'revenue_day' => 0,
                'revenue_month' => 0,
            ];

            $sql = "SELECT COUNT(*) FROM " . self::TB_NAME . " WHERE DATE(created_at) = CURDATE()";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $stats['orders_today'] = $stmt->fetchColumn();

            $sql = "SELECT SUM(total_money) FROM " . self::TB_NAME . " WHERE DATE(created_at) = CURDATE() AND status = 'Đã giao hàng'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $stats['revenue_day'] = $stmt->fetchColumn() ?: 0;

            $sql = "SELECT SUM(total_money) FROM " . self::TB_NAME . " WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND status = 'Đã giao hàng'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $stats['revenue_month'] = $stmt->fetchColumn() ?: 0;

            return $stats;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function CountRows($where_clauses)
    {
        try {
            $sql = "SELECT COUNT(*) FROM " . $this->table_name;

            $sql_clauses_arr = [];
            $values = [];

            if (!empty($where_clauses)) {
                foreach ($where_clauses as $key => $value) {
                    if ($key === 'search_id') {
                        $sql_clauses_arr[] = "orders.order_id LIKE ?";
                        $values[] = "%$value%";
                    } elseif ($key === 'date_from') {
                        $sql_clauses_arr[] = "DATE(orders.created_at) >= ?";
                        $values[] = $value;
                    } elseif ($key === 'date_to') {
                        $sql_clauses_arr[] = "DATE(orders.created_at) <= ?";
                        $values[] = $value;
                    } else {
                        $sql_clauses_arr[] = "$key = ?";
                        $values[] = $value;
                    }
                }
                $sql .= " WHERE " . implode(" AND ", $sql_clauses_arr);
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
    public function getOrderById($order_id)
    {
        $sql = "SELECT 
                o.*, 
                s.full_name AS shipper_name,    
                s.phone_number AS shipper_phone 
            FROM " . self::TB_NAME . " o
            LEFT JOIN users s ON o.shipper_id = s.user_id 
            WHERE o.order_id = ?";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$order_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getRevenueData($status, $start_datetime, $end_datetime, $granularity = 'day')
    {
        try {
            switch ($granularity) {
                case 'month':
                    $period_expr = "DATE_FORMAT(created_at, '%Y-%m')";
                    break;
                case 'year':
                    $period_expr = "YEAR(created_at)";
                    break;
                case 'day':
                default:
                    $period_expr = "DATE(created_at)";
                    break;
            }

            $sql = "SELECT $period_expr AS period, SUM(total_money) AS revenue
                FROM " . self::TB_NAME . "
                WHERE status = ? AND created_at BETWEEN ? AND ?
                GROUP BY period
                ORDER BY period ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$status, $start_datetime, $end_datetime]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getTopItems($status, $start_datetime, $end_datetime, $limit = 20)
    {
        try {
            $limit = (int)$limit;
            $sql = "SELECT oi.food_id, f.food_name, SUM(oi.quantity) AS qty_sold, SUM(oi.quantity * oi.price_at_purchase) AS total_sales
                FROM order_items oi
                JOIN " . self::TB_NAME . " o ON oi.order_id = o.order_id
                JOIN foods f ON oi.food_id = f.food_id
                WHERE o.status = ? AND o.created_at BETWEEN ? AND ?
                GROUP BY oi.food_id
                ORDER BY qty_sold DESC
                LIMIT $limit";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$status, $start_datetime, $end_datetime]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }


    public function validate($data)
    {
        $errors = [];
        if ($err = Validator::is_isset($data->shipper_id, "Shipper không tồn tại"))
            $errors['shipper_id'] = $err;
        elseif ($err = Validator::required($data->shipper_id, "Shipper không được để trống"))
            $errors['shipper_id'] = $err;
        return $errors;
    }
    public function validateUser($data)
    {
        $errors = [];
        if ($err = Validator::is_isset($data->fullname, "Họ và tên người nhận không tồn tại"))
            $errors['fullname'] = $err;
        elseif ($err = Validator::required($data->fullname, "Họ tên người nhận không được để trống"))
            $errors['fullname'] = $err;
        if ($err = Validator::is_isset($data->phone_number, "Số điện thoại không tồn tại"))
            $errors['phone_number'] = $err;
        elseif ($err = Validator::required($data->phone_number, "Số điện thoại không được để trống"))
            $errors['phone_number'] = $err;
        if ($err = Validator::is_isset($data->address, "Địa chỉ không tồn tại"))
            $errors['address'] = $err;
        elseif ($err = Validator::required($data->address, "Địa chỉ không được để trống"))
            $errors['address'] = $err;
        return $errors;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getShipperId()
    {
        return $this->shipper_id;
    }

    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    public function getPaymentStatus()
    {
        return $this->payment_status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setOrderId($order_id): void
    {
        $this->order_id = $order_id;
    }

    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setShipperId($shipper_id): void
    {
        $this->shipper_id = $shipper_id;
    }

    public function setPaymentMethod($payment_method): void
    {
        $this->payment_method = $payment_method;
    }

    public function setPaymentStatus($payment_status): void
    {
        $this->payment_status = $payment_status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function setNote($note): void
    {
        $this->note = $note;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getTotal_money()
    {
        return $this->total_money;
    }


    public function setTotal_money($total_money)
    {
        $this->total_money = $total_money;

        return $this;
    }

    /**
     * Get the value of fullname
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set the value of fullname
     *
     * @return  self
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get the value of phone_number
     */
    public function getPhone_number()
    {
        return $this->phone_number;
    }

    /**
     * Set the value of phone_number
     *
     * @return  self
     */
    public function setPhone_number($phone_number)
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    /**
     * Get the value of address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }
}

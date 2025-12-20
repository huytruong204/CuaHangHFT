<?php
class OrderModel extends BaseModel
{
    public const TB_NAME = "orders";
    protected $order_id;
    protected $user_id;
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
            $sql = "SELECT orders.*, users.full_name 
                    FROM " . self::TB_NAME . " 
                    JOIN users ON " . self::TB_NAME . ".user_id = users.user_id";

            $sql_clauses_arr = [];
            $values = [];

            if (!empty($where_clauses)) {
                foreach ($where_clauses as $column => $value) {
                    $sql_clauses_arr[] = "$column = ?";
                    $values[] = $value;
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
                $value['user_id'] = $value['full_name'] ?? $value['user_id']; 
                $list_orders[] = new OrderModel($value);
            }

            return $list_orders;
        } catch (PDOException $e) {
            $this->error_message = "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    public function CountRows($where_clauses)
    {
        try {
            $sql = "SELECT COUNT(*) FROM " . $this->table_name . " JOIN users ON " . $this->table_name . ".user_id = users.user_id";

            $sql_clauses_arr = [];
            $values = [];

            if (!empty($where_clauses)) {
                foreach ($where_clauses as $column => $value) {
                    if ($column == 'orders.note') {
                        $sql_clauses_arr[] = "$column LIKE ?";
                        $values[] = "%$value%";
                    } else {
                        $sql_clauses_arr[] = "$column = ?";
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
    public function getOrderById($order_id) {
       $sql = "SELECT o.*, u.full_name, u.phone_number, u.address, u.city 
                FROM " . self::TB_NAME . " o
                JOIN users u ON o.user_id = u.user_id 
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
}

<?php
include_once __DIR__ . '/../core/BaseModel.php';

include_once __DIR__ . '/../core/Validator.php';
include_once __DIR__ . '/../Helper/SessionManager.php';

class ReviewModel extends BaseModel
{
    public const TB_NAME = 'reviews';

    protected $review_id;
    protected $user_id;
    protected $food_id;
    protected $order_id;
    protected $rating;
    protected $comment;
    protected $created_at;

    public function __construct($data = [])
    {
        parent::__construct(self::TB_NAME);
        if (!empty($data)) {
            $this->review_id = $data['review_id'] ?? null;
            $this->user_id = $data['user_id'] ?? null;
            $this->food_id = $data['food_id'] ?? null;
            $this->order_id = $data['order_id'] ?? null;
            $this->rating = $data['rating'] ?? null;
            $this->comment = $data['comment'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
        }
    }

    public function requireLogin()
    {
        $user_id = SessionManager::get('user_id');
        if (empty($user_id)) {
            SessionManager::flash('error', 'Vui lòng đăng nhập trước khi đánh giá.');
            header('Location: index.php?page=SignIn');
            exit;
        }
        return $user_id;
    }

    public function getReviewsByFood($food_id)
    {
        try {
            $sql = "SELECT r.*, u.full_name, u.avatar_url
                FROM " . $this->table_name . " r
                JOIN users u ON r.user_id = u.user_id
                WHERE r.food_id = ?
                ORDER BY r.created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$food_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getById($review_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM " . $this->table_name . " WHERE review_id = ? LIMIT 1");
            $stmt->execute([$review_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAvgRatingByFood($food_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total FROM " . $this->table_name . " WHERE food_id = ?");
            $stmt->execute([$food_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return [
                'avg' => isset($row['avg_rating']) ? (float)$row['avg_rating'] : 0.0,
                'count' => isset($row['total']) ? (int)$row['total'] : 0
            ];
        } catch (PDOException $e) {
            return ['avg' => 0.0, 'count' => 0];
        }
    }

    public function getRecent($limit = 10)
    {
        try {
            $stmt = $this->db->prepare("SELECT r.*, u.full_name, f.food_name
                FROM " . $this->table_name . " r
                JOIN users u ON r.user_id = u.user_id
                JOIN foods f ON r.food_id = f.food_id
                ORDER BY r.created_at DESC
                LIMIT ?");
            $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function countForAdmin(array $filters = [])
    {
        try {
            $where = '';
            $params = [];
            if (!empty($filters['keyword'])) {
                $kw = '%' . trim($filters['keyword']) . '%';
                $where .= " AND (f.food_name LIKE ? OR u.full_name LIKE ? )";
                $params[] = $kw; $params[] = $kw;
            }
            if (isset($filters['rating']) && $filters['rating'] !== '') {
                $where .= " AND r.rating = ?";
                $params[] = (int)$filters['rating'];
            }
            if (!empty($filters['start_date'])) {
                $where .= " AND r.created_at >= ?";
                $params[] = $filters['start_date'] . ' 00:00:00';
            }
            if (!empty($filters['end_date'])) {
                $where .= " AND r.created_at <= ?";
                $params[] = $filters['end_date'] . ' 23:59:59';
            }

            $sql = "SELECT COUNT(*) FROM " . $this->table_name . " r JOIN foods f ON r.food_id = f.food_id JOIN users u ON r.user_id = u.user_id WHERE 1=1 " . $where;
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getListForAdmin(array $filters = [], int $offset = 0, int $limit = 10)
    {
        try {
            $where = '';
            $params = [];
            if (!empty($filters['keyword'])) {
                $kw = '%' . trim($filters['keyword']) . '%';
                $where .= " AND (f.food_name LIKE ? OR u.full_name LIKE ? )";
                $params[] = $kw; $params[] = $kw;
            }
            if (isset($filters['rating']) && $filters['rating'] !== '') {
                $where .= " AND r.rating = ?";
                $params[] = (int)$filters['rating'];
            }
            if (!empty($filters['start_date'])) {
                $where .= " AND r.created_at >= ?";
                $params[] = $filters['start_date'] . ' 00:00:00';
            }
            if (!empty($filters['end_date'])) {
                $where .= " AND r.created_at <= ?";
                $params[] = $filters['end_date'] . ' 23:59:59';
            }

            $sql = "SELECT r.*, u.full_name AS user_name, f.food_name
                FROM " . $this->table_name . " r
                JOIN users u ON r.user_id = u.user_id
                JOIN foods f ON r.food_id = f.food_id
                WHERE 1=1 " . $where . " ORDER BY r.created_at DESC LIMIT ? , ?";

            $stmt = $this->db->prepare($sql);
            // bind filter params
            $i = 1;
            foreach ($params as $p) {
                $stmt->bindValue($i, $p);
                $i++;
            }
            // bind offset and limit as integers
            $stmt->bindValue($i, (int)$offset, PDO::PARAM_INT); $i++;
            $stmt->bindValue($i, (int)$limit, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getByUserOrderFood($user_id, $food_id, $order_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM " . $this->table_name . " WHERE user_id = ? AND food_id = ? AND order_id = ? LIMIT 1");
            $stmt->execute([$user_id, $food_id, $order_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function validate($data, $mode = 'full')
    {
        $mode = strtolower($mode ?? 'full');
        $errors = [];

        // If basic or full, validate rating/comment
        if ($mode === 'basic' || $mode === 'full') {
            $rating = is_object($data) ? ($data->rating ?? null) : ($data['rating'] ?? null);
            if ($err = Validator::is_isset($rating, 'Đánh giá không tồn tại')) {
                $errors['rating'] = $err;
            } elseif ($err = Validator::required($rating, 'Đánh giá không được để trống')) {
                $errors['rating'] = $err;
            } elseif ($err = Validator::numeric($rating, 'Đánh giá phải là số')) {
                $errors['rating'] = $err;
            } else {
                $ratingVal = (int)$rating;
                if ($ratingVal < 1 || $ratingVal > 5) {
                    $errors['rating'] = 'Đánh giá phải ở giữa 1 và 5';
                }
            }

            $comment = is_object($data) ? ($data->comment ?? '') : ($data['comment'] ?? '');
            if (!empty($comment) && strlen($comment) > 2000) {
                $errors['comment'] = 'Bình luận quá dài (tối đa 2000 ký tự)';
            }
        }

        // If view or full, validate business rules (ids, order, ownership, status, item, duplicate)
        if ($mode === 'view' || $mode === 'full') {
            if ($err = Validator::is_isset($data['user_id'] ?? null, 'User_id không tồn tại')) $errors['user_id'] = $err;
            if ($err = Validator::is_isset($data['food_id'] ?? null, 'Food_id không tồn tại')) $errors['food_id'] = $err;
            if ($err = Validator::is_isset($data['order_id'] ?? null, 'Order_id không tồn tại')) $errors['order_id'] = $err;

            if (!empty($errors)) return $errors;

            include_once __DIR__ . '/OrderModel.php';
            include_once __DIR__ . '/OrderItemModel.php';

            $orderModel = new OrderModel();
            $order = $orderModel->getOrderById($data['order_id']);
            if (!$order) {
                $errors['order'] = 'Không tìm thấy đơn hàng.';
                return $errors;
            }

            if ($order['user_id'] != $data['user_id']) {
                $errors['permission'] = 'Bạn không có quyền đánh giá đơn hàng này.';
                return $errors;
            }

            if (($order['status'] ?? '') !== 'Đã giao hàng') {
                $errors['status'] = 'Chỉ có thể đánh giá sau khi nhận hàng.';
                return $errors;
            }

            $orderItemModel = new OrderItemModel();
            $items = $orderItemModel->getOrderItems($data['order_id']);
            $found = false;
            foreach ($items as $it) {
                if ($it['food_id'] == $data['food_id']) { $found = true; break; }
            }
            if (!$found) {
                $errors['item'] = 'Sản phẩm không thuộc đơn hàng.';
                return $errors;
            }

            // Duplicate check
            $existing = $this->getReviewsByFood($data['food_id']);
            foreach ($existing as $r) {
                if (($r['user_id'] ?? null) == $data['user_id'] && ($r['order_id'] ?? null) == $data['order_id']) {
                    $errors['duplicate'] = 'Bạn đã đánh giá sản phẩm này cho đơn hàng này.';
                    return $errors;
                }
            }
        }

        return $errors;
    }


    public function createValidated(array $data)
    {
        $errors = $this->validate($data, 'full');
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $id = $this->Insert($data);
        if ($id === false) {
            return ['success' => false, 'errors' => ['db' => $this->error_message]];
        }

        return ['success' => true, 'id' => $id];
    }


    public function createAndRedirect(array $data)
    {
        $res = $this->createValidated($data);
        if (!$res['success']) {
            return $res;
        }

        // Success: thank user and redirect to order detail
        SessionManager::flash('success', 'Cảm ơn bạn đã đánh giá.');
        $order_id = $data['order_id'] ?? '';
        header("Location: index.php?page=Order&action=Detail&order_id=$order_id");
        exit;
    }

    // Getters and setters
    public function getReview_id()
    {
        return $this->review_id;
    }

    public function setReview_id($review_id)
    {
        $this->review_id = $review_id;
        return $this;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getFood_id()
    {
        return $this->food_id;
    }

    public function setFood_id($food_id)
    {
        $this->food_id = $food_id;
        return $this;
    }

    public function getOrder_id()
    {
        return $this->order_id;
    }

    public function setOrder_id($order_id)
    {
        $this->order_id = $order_id;
        return $this;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }
}

<?php
include_once __DIR__ . '/../core/BaseModel.php';
class InvoiceModel extends BaseModel
{
    public const TB_NAME = 'invoices';

    public function __construct()
    {
        parent::__construct(self::TB_NAME);
    }

    public function getByOrderId($order_id)
    {
        try {
            $sql = "SELECT * FROM " . $this->table_name . " WHERE order_id = ? LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$order_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getById($invoice_id)
    {
        try {
            $sql = "SELECT * FROM " . $this->table_name . " WHERE invoice_id = ? LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$invoice_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}

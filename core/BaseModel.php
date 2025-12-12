<?php
require_once "Database.php";
class BaseModel
{
    protected $db;
    protected $table_name;
    public $error_message = "";
    public function __construct($table_name)
    {
        $this->db = Database::get_instance()->getConn();
        $this->table_name = $table_name;
    }

    public function Insert($data)
    {
        try {
            $anonymous = array_fill(0, count($data), '?');
            $columns = array_keys($data);
            $values = array_values($data);
            $stmt = $this->db->prepare("INSERT INTO $this->table_name (" . implode(",", $columns) . ") VALUES (" . implode(",", $anonymous) . ")");
            $stmt->execute($values);
            return true;
        } catch (PDOException $e) {
            $errorCode = isset($e->errorInfo[1]) ? $e->errorInfo[1] : 0;
            switch ($errorCode) {
                case 1062:
                    $this->error_message = "Dữ liệu này đã tồn tại. Vui lòng kiểm tra lại.";
                    break;
                case 1406:
                    $this->error_message = "Dữ liệu nhập vào quá dài so với quy định.";
                    break;
                default:
                    $this->error_message = "Lỗi hệ thống: " . $e->getMessage();
                    break;
            }
        }
    }
}

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
            return false;
        }
    }
    public function Update($data, $condition_col, $condition_val)
    {
        try {
            $columns = array_keys($data);
            $values = array_values($data);
            $sql_update = [];

            for ($i = 0; $i < count($columns); $i++) {
                $sql_update[] = "$columns[$i] = ?";
            }

            $sql_update_str = implode(", ", $sql_update);

            if (empty($sql_update)) {
                $this->error_message = "Không có dữ liệu để cập nhật.";
                return false;
            }
            array_push($values, $condition_val);
            $stmt = $this->db->prepare("UPDATE $this->table_name SET $sql_update_str WHERE $condition_col = ?");
            $stmt->execute($values);
            return true;
        } catch (PDOException $e) {
            $errorCode = isset($e->errorInfo[1]) ? $e->errorInfo[1] : 0;
            switch ($errorCode) {
                case 1062:
                    $this->error_message = "Dữ liệu cập nhật bị trùng lặp.";
                    break;
                case 1406:
                    $this->error_message = "Dữ liệu nhập vào quá dài.";
                    break;
                default:
                    $this->error_message = "Lỗi hệ thống: " . $e->getMessage();
                    break;
            }
            return false;
        }
    }
    public function Delete($condition_col, $condition_val)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM $this->table_name WHERE $condition_col = ?");
            $stmt->execute([$condition_val]);
            return true;
        } catch (PDOException $e) {
            $errorCode = isset($e->errorInfo[1]) ? $e->errorInfo[1] : 0;
            switch ($errorCode) {
                case 1451:
                    $this->error_message = "Không thể xóa dữ liệu này vì nó đang được sử dụng ở bảng khác (Lỗi ràng buộc khóa ngoại).";
                    break;
                default:
                    $this->error_message = "Lỗi hệ thống: " . $e->getMessage();
                    break;
            }
            return false;
        }
    }
}

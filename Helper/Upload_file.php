<?php
class Helper
{
    public static function Upload_image($image_file, $folder)
    {
        $result = [
            'status' => false,
            'file_name' => '',
            'message' => ''
        ];
        if (!isset($image_file) || $image_file['error'] != 0 || empty($image_file["tmp_name"])){
            $result['message'] = "Chưa chọn ảnh";
            return $result;
        }

        $image_type = exif_imagetype($image_file["tmp_name"]);
        if (!$image_type){
            $result['message'] = "Tệp đã tải lên không phải là hình ảnh.";
            return $result;
        }

        $image_extension = image_type_to_extension($image_type, true);
        $origin_name = pathinfo($image_file['name'], PATHINFO_FILENAME);
        $image_name = $origin_name ."-". bin2hex(random_bytes(16)) . $image_extension;
        $targetPath = $folder . $image_name;
        if (move_uploaded_file($image_file["tmp_name"], $targetPath))
        {
            $result['status'] = true;
            $result['file_name'] = $image_name;
            $result['message'] = "Upload thành công.";
            return $result;
        }else {
            $result['message'] = "Lỗi khi di chuyển file vào thư mục.";
        }
        return $result;
    }
}

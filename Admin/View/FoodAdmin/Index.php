<div class="container-fluid pt-4 px-4">
    <div class="row min-vh-100 bg-secondary rounded  justify-content-center mx-0">
        <div class="container-fluid pt-4 px-4">
            <div class="col-xl-12 ">
                <div class="bg-secondary rounded h-100 p-2">
                    <div class="row justify-content-between">
                        <h3 class=" col-auto mb-4">Quản lý món ăn</h3>
                        <div class="col-auto">
                            <a href='index.php?page=FoodAdmin&action=CreateGet' class='btn btn-outline-success'>Thêm món ăn mới</a>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 120px">Mã món ăn</th>
                                <th scope="col" class="text-wrap" style="width: 120px">Danh mục</th>
                                <th scope="col" class="text-wrap" style="width: 120px">Tên món ăn</th>
                                <th scope="col" style="width: 120px">Giá bán</th>
                                <th scope="col" style="width: 200px">Ảnh món ăn</th>
                                <th scope="col" style="width: 80px">Trạng thái</th>
                                <th scope="col" style="width: 120px">Ngày tạo</th>
                                <th scope="col" style="width: 250px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list_foods as $value) {
                                $price_format = number_format($value->getPrice(), 0, ',', '.') . 'đ';
                                $status = '';
                                if ($value->getStatus() == 1)
                                    $status = "Đang bán";
                                else
                                    $status = "Ngừng bán";
                                echo "
                                    <tr>
                                        <th scope='row'>{$value->getFood_id()}</th>
                                        <td>{$value->getCategory_id()}</td>
                                        <td>{$value->getFood_name()}</td>
                                        <td>{$price_format}</td>
                                        <td>
                                            <img src='../assets/img/img_foods/{$value->getImage_url()}''
                                                style='width: 180px; height: 180px; object-fit: cover; border-radius: 5px; border: 1px solid #555;'>
                                        </td>
                                        <td>{$status}</td>
                                        <td>{$value->getCreated_at()}</td>
                                        <td>
                                            <div class='d-flex justify-content-center gap-1'>
                                                    <a href='index.php?page=FoodAdmin&action=Detail&food_id={$value->getFood_id()}' class='col-xl-4 btn btn-outline-info'>Chi tiết</a>
                                                    <a href='index.php?page=FoodAdmin&action=UpdateGet&food_id={$value->getFood_id()}'  class='col-xl-4 btn btn-outline-warning'>Cập nhật</a>
                                                    <a href='#'  class='col-xl-4 btn btn-outline-danger'>Xóa</a>
                                            </div>
                                        </td>
                                    </tr>
                                ";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid pt-4 px-4">
    <div class="row  bg-secondary rounded  justify-content-center mx-0" style="min-height: 80vh;">
        <div class="container-fluid pt-4 px-4">
            <div class="col-xl-12">
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
                            if (empty($list_foods)) {
                                echo "
                                    <tr class='text-center'>
                                        <th scope='row' colspan='8'>Chưa có món ăn nào.</th>
                                    </tr>
                                ";
                            } else {
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
                                                    <a href='index.php?page=FoodAdmin&action=Detail&food_id={$value->getFood_id()}' class='btn btn-outline-info'>Chi tiết</a>
                                                    <a href='index.php?page=FoodAdmin&action=UpdateGet&food_id={$value->getFood_id()}'  class='btn btn-outline-warning'>Cập nhật</a>
                                                    <form action='index.php?page=FoodAdmin&action=Delete' method='POST' >
                                                        <input type='hidden' name='food_id' value='{$value->getFood_id()}'>
                                                        <button type='submit' class='btn btn-outline-danger' 
                                                                onclick='return confirm(\"Bạn có chắc chắn muốn xóa món {$value->getFood_name()} không?\");'>
                                                                Xóa
                                                        </button>   
                                                    </form>
                                            </div>
                                        </td>
                                    </tr>
                                ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4 ">
    <nav aria-label="Page navigation">
        <ul class="pagination ">
            <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="index.php?page=FoodAdmin&p=<?= $current_page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                    <a class="page-link" href="index.php?page=FoodAdmin&p=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="index.php?page=FoodAdmin&p=<?= $current_page + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
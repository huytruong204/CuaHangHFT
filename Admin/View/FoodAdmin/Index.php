

<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-primary">Quản lý món ăn</h3>
            <a href='index.php?page=FoodAdmin&action=CreateGet' class='btn btn-primary'>
                <i class="fa fa-plus me-2"></i>Thêm món mới
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 100px">Mã món</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col" class="text-start">Tên món ăn</th>
                        <th scope="col">Giá bán</th>
                        <th scope="col" class="text-center">Ảnh</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col" style="width: 150px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($list_foods)) {
                        echo "
                            <tr>
                                <td colspan='8' class='text-center py-5 text-muted'>
                                    <i class='fa fa-box-open fa-3x mb-3'></i>
                                    <p>Chưa có món ăn nào trong dữ liệu.</p>
                                </td>
                            </tr>
                        ";
                    } else {
                        foreach ($list_foods as $value) {
                            // Xử lý logic hiển thị
                            $price_format = number_format($value->getPrice(), 0, ',', '.') . 'đ';
                            $img_src = '../assets/img/img_foods/' . $value->getImage_url();
                            
                            $status = '';
                            if ($value->getStatus() == 1)
                                $status = "<span class='badge bg-success'>Đang bán</span>";
                            else
                                $status = "<span class='badge bg-danger'>Ngừng bán</span>";

                            // In ra HTML
                            echo "
                                <tr>
                                    <th scope='row'>{$value->getFood_id()}</th>
                                    <td>{$value->getCategory_id()}</td>
                                    <td class='text-start fw-bold'>{$value->getFood_name()}</td>
                                    <td class='text-danger fw-bold'>{$price_format}</td>
                                    <td class='text-center'>
                                        <img src='{$img_src}' alt='Img'
                                             class='rounded shadow-sm'
                                             style='width: 50px; height: 50px; object-fit: cover; border: 1px solid #eee;'>
                                    </td>
                                    <td>{$status}</td>
                                    <td><small class='text-muted'>{$value->getCreated_at()}</small></td>
                                    <td>
                                        <div class='d-flex justify-content-center gap-2'>
                                            <a href='index.php?page=FoodAdmin&action=Detail&food_id={$value->getFood_id()}' 
                                               class='btn btn-sm btn-outline-info' title='Chi tiết'><i class='fa fa-eye'></i></a>
                                               
                                            <a href='index.php?page=FoodAdmin&action=UpdateGet&food_id={$value->getFood_id()}' 
                                               class='btn btn-sm btn-outline-warning' title='Sửa'><i class='fa fa-pen'></i></a>
                                            
                                            <form action='index.php?page=FoodAdmin&action=Delete' method='POST' style='display:inline;'>
                                                <input type='hidden' name='food_id' value='{$value->getFood_id()}'>
                                                <button type='submit' class='btn btn-sm btn-outline-danger' 
                                                        onclick='return confirm(\"Bạn có chắc chắn muốn xóa món {$value->getFood_name()} không?\");' title='Xóa'>
                                                    <i class='fa fa-trash'></i>
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

        <?php if (isset($total_pages) && $total_pages > 1): ?>
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <?php 
                        $prev_disabled = ($current_page <= 1) ? 'disabled' : '';
                        $prev_page = $current_page - 1;
                        echo "
                        <li class='page-item $prev_disabled'>
                            <a class='page-link' href='index.php?page=FoodAdmin&p=$prev_page' aria-label='Previous'>
                                <span aria-hidden='true'>&laquo;</span>
                            </a>
                        </li>";
                    ?>

                    <?php 
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = ($i == $current_page) ? 'active' : '';
                            echo "
                            <li class='page-item $active'>
                                <a class='page-link' href='index.php?page=FoodAdmin&p=$i'>$i</a>
                            </li>";
                        }
                    ?>

                    <?php 
                        $next_disabled = ($current_page >= $total_pages) ? 'disabled' : '';
                        $next_page = $current_page + 1;
                        echo "
                        <li class='page-item $next_disabled'>
                            <a class='page-link' href='index.php?page=FoodAdmin&p=$next_page' aria-label='Next'>
                                <span aria-hidden='true'>&raquo;</span>
                            </a>
                        </li>";
                    ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
        
    </div>
</div>

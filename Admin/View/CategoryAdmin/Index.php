<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-primary">Quản lý danh mục</h3>
            <a href='index.php?page=CategoryAdmin&action=CreateGet&p=<?php echo $current_page?>' class='btn btn-primary'>
                <i class="fa fa-plus me-2"></i>Thêm danh mục mới
            </a>
        </div>
        <form action="index.php" method="GET" class="mb-4">
            <input type="hidden" name="page" value="CategoryAdmin">

            <div class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="fa fa-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0" name="keyword"
                            value="<?php if(isset($_GET['keyword'])) echo htmlspecialchars($_GET['keyword']) ?>" placeholder="Nhập tên danh mục...">
                    </div>
                </div>

                <div class="col-md-8 d-flex gap-1">
                    <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i> Tìm</button>
                    <a href="index.php?page=CategoryAdmin" class="btn btn-outline-secondary" title="Xóa tìm"><i class="fa fa-sync"></i></a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 150px">Mã danh mục</th>
                        <th scope="col" >Tên danh mục</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col" style="width: 150px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($list_categories)) {
                        echo "
                            <tr>
                                <td colspan='8' class='text-center py-5 text-muted'>
                                    <i class='fa fa-box-open fa-3x mb-3'></i>
                                    <p>Chưa có danh mục nào trong dữ liệu.</p>
                                </td>
                            </tr>
                        ";
                    } else {
                        foreach ($list_categories as $value) {
                            // In ra HTML
                            echo "
                                <tr>
                                    <th scope='row'>{$value->getCategory_id()}</th>
                                    <td>{$value->getCategory_name()}</td>
                                    <td>{$value->getDescription()}</td>
                                    <td><small class='text-muted'>{$value->getCreated_at()}</small></td>
                                    <td>
                                        <div class='d-flex justify-content-center gap-2'>
                                               
                                            <a href='index.php?page=CategoryAdmin&action=UpdateGet&category_id={$value->getCategory_id()}&p=$current_page' 
                                               class='btn btn-sm btn-outline-warning' title='Sửa'><i class='fa fa-pen'></i></a>
                                            
                                            <form action='index.php?page=CategoryAdmin&action=Delete' method='POST' style='display:inline;'>
                                                <input type='hidden' name='category_id' value='{$value->getCategory_id()}'>
                                                <button type='submit' class='btn btn-sm btn-outline-danger' 
                                                        onclick='return confirm(\"Bạn có chắc chắn muốn xóa danh mục {$value->getCategory_name()} không?\");' title='Xóa'>
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

        <?php if (isset($total_pages) && $total_pages > 1): 
            $params = $_GET; 
            unset($params['p']); 
            $query_str = http_build_query($params); 
            ?>
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0">
                        <?php
                        $prev_disabled = ($current_page <= 1) ? 'disabled' : '';
                        $prev_page = $current_page - 1;
                        echo "
                        <li class='page-item $prev_disabled'>
                            <a class='page-link' href='index.php?$query_str&p=$prev_page' aria-label='Previous'>
                                <span aria-hidden='true'>&laquo;</span>
                            </a>
                        </li>";
                        ?>

                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = ($i == $current_page) ? 'active' : '';
                            echo "
                            <li class='page-item $active'>
                                <a class='page-link' href='index.php?$query_str&p=$i'>$i</a>
                            </li>";
                        }
                        ?>

                        <?php
                        $next_disabled = ($current_page >= $total_pages) ? 'disabled' : '';
                        $next_page = $current_page + 1;
                        echo "
                        <li class='page-item $next_disabled'>
                            <a class='page-link' href='index.php?$query_str&p=$next_page' aria-label='Next'>
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
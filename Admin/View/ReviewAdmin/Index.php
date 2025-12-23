<?php
// Admin review list view
?>
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-primary">Quản lý đánh giá</h3>
            <div></div>
        </div>

        <?php if (!empty($msg_success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($msg_success) ?></div>
        <?php endif; ?>
        <?php if (!empty($msg_error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($msg_error) ?></div>
        <?php endif; ?>

        <form action="index.php" method="GET" class="mb-4">
            <input type="hidden" name="page" value="ReviewAdmin">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên món hoặc khách" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                </div>

                <div class="col-md-2">
                    <select name="rating" class="form-select">
                        <option value="">-- Tất cả đánh giá --</option>
                        <?php for ($r = 5; $r >= 1; $r--): ?>
                            <option value="<?= $r ?>" <?= (isset($_GET['rating']) && $_GET['rating'] == $r) ? 'selected' : '' ?>><?= $r ?> sao</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="date" class="form-control" name="start_date" min="2025-01-01" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
                </div>

                <div class="col-md-2">
                    <input type="date" class="form-control" name="end_date" min="2025-01-01" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
                </div>

                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter"></i> Lọc</button>
                    <a href="index.php?page=ReviewAdmin" class="btn btn-outline-light" title="Xóa lọc"><i class="fa fa-sync"></i></a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-start">
                <thead>
                    <tr>
                        <th style="width:80px">ID</th>
                        <th>Khách hàng</th>
                        <th>Món</th>
                        <th style="width:120px">Đánh giá</th>
                        <th>Bình luận</th>
                        <th style="width:160px">Ngày</th>
                        <th style="width:160px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reviews)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Không có đánh giá.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reviews as $rv): ?>
                            <tr>
                                <td class="fw-bold">#<?= htmlspecialchars($rv['review_id']) ?></td>
                                <td><?= htmlspecialchars($rv['user_name'] ?? ($rv['full_name'] ?? '')) ?></td>
                                <td><?= htmlspecialchars($rv['food_name'] ?? '') ?></td>
                                <td>
                                    <span class="badge bg-warning text-dark"><?= htmlspecialchars($rv['rating']) ?>★</span>
                                </td>
                                <td><?= nl2br(htmlspecialchars($rv['comment'])) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($rv['created_at'] ?? 'now')) ?></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <form method="POST" action="index.php?page=ReviewAdmin&action=Delete" onsubmit="return confirm('Xác nhận xóa đánh giá #<?= $rv['review_id'] ?>?');" style="display:inline-block;">
                                            <input type="hidden" name="review_id" value="<?= $rv['review_id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class='fa fa-trash'></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
                        echo "<li class='page-item $prev_disabled'><a class='page-link' href='index.php?$query_str&p=$prev_page' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
                        ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++):
                            $active = ($i == $current_page) ? 'active' : '';
                            echo "<li class='page-item $active'><a class='page-link' href='index.php?$query_str&p=$i'>$i</a></li>";
                        endfor; ?>

                        <?php
                        $next_disabled = ($current_page >= $total_pages) ? 'disabled' : '';
                        $next_page = $current_page + 1;
                        echo "<li class='page-item $next_disabled'><a class='page-link' href='index.php?$query_str&p=$next_page' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
                        ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>

    </div>
</div>
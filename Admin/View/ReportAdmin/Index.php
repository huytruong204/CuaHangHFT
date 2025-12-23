<div class="container-fluid pt-4 px-4">

    <div class="bg-secondary text-center rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-primary">Báo cáo doanh thu</h3>
            <div></div>
        </div>

        <?php if (!empty($msg_success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($msg_success) ?></div>
        <?php endif; ?>
        <?php if (!empty($msg_error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($msg_error) ?></div>
        <?php endif; ?>

        <form action="index.php" method="GET" class="mb-4">
            <input type="hidden" name="page" value="reportAdmin">
            <div class="row g-2">
                <div class="col-md-3">
                    <select class="form-select" name="granularity">
                        <?php foreach ($granularity_options as $k => $label):
                            $is_selected = (isset($_GET['granularity']) && $_GET['granularity'] === $k) ? 'selected' : '';
                        ?>
                            <option value="<?= $k ?>" <?= $is_selected ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="date" class="form-control" min="2025-01-01" name="start_date" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>">
                </div>

                <div class="col-md-3">
                    <input type="date" class="form-control" min="2025-01-01" name="end_date" value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>">
                </div>

                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter"></i> Lọc</button>
                    <a href="index.php?page=reportAdmin" class="btn btn-outline-light" title="Xóa lọc"><i class="fa fa-sync"></i></a>
                </div>
            </div>
        </form>

        <?php if (!empty($revenue_data)): ?>
        <div class="card mb-4">
            <div class="card-body">
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-info text-center">Không có dữ liệu để hiển thị</div>
        <?php endif; ?>

        <h3 class="text-start">Top món bán chạy</h3>
        <div class="table-responsive card p-3">
            <table class="table table-hover align-middle text-start mb-0 report-table">
                <thead>
                    <tr><th style="width:40px">#</th><th>Tên món</th><th style="width:140px">Số lượng bán</th><th style="width:160px">Doanh thu</th></tr>
                </thead>
                <tbody>
                <?php if (empty($top_items)): ?>
                    <tr><td colspan="4" class="text-center py-4 text-muted">Không có dữ liệu</td></tr>
                <?php else: ?>
                    <?php $i = 1; $total_sales_sum = 0; foreach ($top_items as $it): $total_sales_sum += (float)$it['total_sales']; ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($it['food_name']) ?></td>
                            <td><?= number_format($it['qty_sold']) ?></td>
                            <td class="text-danger fw-bold"><?= number_format($it['total_sales'], 0, ',', '.') ?> đ</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-light">
                        <td></td>
                        <td class="fw-bold">Tổng doanh thu:</td>
                        <td></td>
                        <td class="fw-bold"><?= number_format($total_sales_sum, 0, ',', '.') ?> đ</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php if (!empty($revenue_data)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const revenueData = <?php echo json_encode(array_map(function($r){ return (float)$r['revenue']; }, $revenue_data)); ?>;
    const revenueLabels = <?php echo json_encode(array_column($revenue_data, 'period')); ?>;

    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Doanh thu',
                data: revenueData,
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });
</script>
<?php endif; ?>

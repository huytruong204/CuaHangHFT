<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-primary">Quản lý đơn hàng</h3>
        </div>

        <?php if (!empty($msg_success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($msg_success) ?></div>
        <?php endif; ?>
        <?php if (!empty($msg_error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($msg_error) ?></div>
        <?php endif; ?>

        <form action="index.php" method="GET" class="mb-4">
            <input type="hidden" name="page" value="OrderAdmin">
            
            <div class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label text-start d-block small">Mã đơn hàng</label>
                    <input type="text" class="form-control" name="search_id" 
                           placeholder="#ID..." 
                           value="<?= isset($_GET['search_id']) ? htmlspecialchars($_GET['search_id']) : '' ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label text-start d-block small">Trạng thái</label>
                    <select class="form-select" name="status">
                        <option value="">-- Tất cả --</option>
                        <?php foreach ($status_map as $key => $label): 
                            $is_selected = (isset($_GET['status']) && $_GET['status'] === $key) ? 'selected' : '';
                        ?>
                            <option value="<?= $key ?>" <?= $is_selected ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-start d-block small">Từ ngày</label>
                    <input type="date" class="form-control" name="date_from" 
                           value="<?= isset($_GET['date_from']) ? htmlspecialchars($_GET['date_from']) : '' ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label text-start d-block small">Đến ngày</label>
                    <input type="date" class="form-control" name="date_to" 
                           value="<?= isset($_GET['date_to']) ? htmlspecialchars($_GET['date_to']) : '' ?>">
                </div>

                <div class="col-md-3 d-flex gap-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter"></i> Lọc</button>
                    <a href="index.php?page=OrderAdmin" class="btn btn-outline-dark" title="Xóa lọc"><i class="fa fa-sync"></i></a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-start">
                <thead>
                    <tr>
                        <th scope="col" class="width-100">Mã ĐH</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Ngày đặt</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col" class="text-center width-150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa fa-search fa-3x mb-3"></i>
                                <p>Không tìm thấy đơn hàng nào phù hợp với điều kiện lọc.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <?php
                            // Logic màu sắc giữ nguyên như cũ
                            $statusColor = 'secondary';
                            switch ($order->getStatus()) {
                                case 'Chờ xác nhận': $statusColor = 'warning text-dark'; break;
                                case 'Đã xác nhận': $statusColor = 'info text-dark'; break;
                                case 'Đang chuẩn bị': 
                                case 'Chờ shipper':
                                case 'Đang giao hàng': $statusColor = 'primary'; break;
                                case 'Đã giao hàng': $statusColor = 'success'; break;
                                case 'Đã hủy':
                                case 'Hoàn tiền': $statusColor = 'danger'; break;
                            }
                            ?>
                            <tr>
                                <td class="fw-bold">#<?= $order->getOrderId() ?></td>
                                <td><span class="fw-bold"><?= htmlspecialchars($order->getUserId()) ?></span></td>
                                <td><?= date('d/m/Y H:i', strtotime($order->getCreatedAt() ?? 'now')) ?></td>
                                <td class="text-danger fw-bold">
                                    <?= number_format($order->getTotal_money(), 0, ',', '.') ?>đ
                                </td>
                                <td>
                                    <span class="badge bg-<?= $statusColor ?>"><?= $order->getStatus() ?></span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="index.php?page=OrderAdmin&action=Detail&order_id=<?= $order->getOrderId() ?>"
                                            class="btn btn-sm btn-outline-info btn-sm-wide minw-110" title="Xem chi tiết">
                                            <i class="fa fa-eye"></i> <span class="ml-6">Chi tiết</span>
                                        </a>
                                         <button type="button" 
                                                    class="btn btn-sm btn-outline-success" 
                                                    title="In hóa đơn" 
                                                    style="white-space:nowrap;padding:6px 12px;min-width:90px;" 
                                                    onclick="printInvoice(<?= $order->getOrderId() ?>)">
                                                In
                                        </button>
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
                        echo "<li class='page-item $prev_disabled'><a class='page-link' href='index.php?$query_str&p=$prev_page'>&laquo;</a></li>";

                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = ($i == $current_page) ? 'active' : '';
                            echo "<li class='page-item $active'><a class='page-link' href='index.php?$query_str&p=$i'>$i</a></li>";
                        }

                        $next_disabled = ($current_page >= $total_pages) ? 'disabled' : '';
                        $next_page = $current_page + 1;
                        echo "<li class='page-item $next_disabled'><a class='page-link' href='index.php?$query_str&p=$next_page'>&raquo;</a></li>";
                        ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>

    </div>
</div>
<script>
function printInvoice(orderId) {
    // Tạo form data để gửi giống như form POST cũ
    var formData = new FormData();
    formData.append('order_id', orderId);

    // Sử dụng Fetch API để gọi file Pdf.php
    fetch('../Helper/Pdf.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Lỗi khi tạo file PDF');
        }
        return response.blob(); // Chuyển phản hồi thành dạng Blob (file nhị phân)
    })
    .then(blob => {
        // Tạo một URL tạm thời cho file PDF Blob
        var url = URL.createObjectURL(blob);

        // Tạo một iframe ẩn
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = url;
        iframe.id = 'pdfIframe';

        // Thêm iframe vào trang web
        document.body.appendChild(iframe);

        // Đợi iframe tải xong nội dung PDF thì gọi lệnh in
        iframe.onload = function() {
            setTimeout(function() {
                try {
                    // Gọi lệnh in trên cửa sổ của iframe
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                } catch (e) {
                    alert("Trình duyệt không hỗ trợ in tự động iframe. Vui lòng tải file về.");
                }
            }, 500); // Đợi 0.5s để đảm bảo render xong
        };
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi tải hóa đơn.');
    });
}
</script>
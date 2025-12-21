<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-primary">Chi tiết đơn hàng #<?= $order['order_id'] ?></h3>
            <a href="index.php?page=orderAdmin" class="btn btn-outline-danger">
                <i class="fa fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
        <?php if (!empty($msg = SessionManager::flash('error'))): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h5 class="mb-3 text-dark border-bottom pb-2"><i class="fa fa-user me-2"></i>Thông tin khách hàng</h5>
                    <p class="mb-2 text-dark"><strong>Họ tên:</strong> <?= $order['full_name'] ?></p>
                    <p class="mb-2 text-dark"><strong>Số điện thoại:</strong> <?= $order['phone_number'] ?></p>
                    <p class="mb-2 text-dark"><strong>Địa chỉ:</strong> <?= $order['address'] ?></p>
                    <p class="mb-0 text-dark"><strong>Thành phố:</strong> <?= $order['city'] ?></p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h5 class="mb-3 text-dark border-bottom pb-2"><i class="fa fa-file-invoice me-2"></i>Thông tin vận đơn</h5>
                    <p class="mb-2 text-dark"><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                    <p class="mb-2 text-dark"><strong>Phương thức TT:</strong> <?= $order['payment_method'] == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản' ?></p>
                    <p class="mb-2 text-dark"><strong>Trạng thái TT:</strong> <?= $order['payment_status'] == '1' ? 'Đã thanh toán' : 'Chưa thanh toán' ?></p>
                    <p class="mb-2 text-dark"><strong>Ghi chú:</strong> <em class="text-muted"><?= empty($order['note']) ? 'Không có' : $order['note'] ?></em></p>

                    <?php
                    $statusColor = 'secondary';
                    switch ($order['status']) {
                        case 'Chờ xác nhận':
                            $statusColor = 'warning text-dark';
                            break;
                        case 'Đã xác nhận':
                            $statusColor = 'info text-dark';
                            break;
                        case 'Đang chuẩn bị':
                        case 'Chờ shipper':
                        case 'Đang giao hàng':
                            $statusColor = 'primary';
                            break;
                        case 'Đã giao hàng':
                            $statusColor = 'success';
                            break;
                        case 'Đã hủy':
                        case 'Hoàn tiền':
                            $statusColor = 'danger';
                            break;
                    }
                    ?>
                    <p class="mb-0 text-dark"><strong>Trạng thái:</strong> <span class="badge bg-<?= $statusColor ?>"><?= $order['status'] ?></span></p>
                </div>
            </div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table table-hover align-middle text-start">
                <thead class="">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col" class="text-center">Số lượng</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col" class="text-end">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-dark">
                    <?php
                    $total_calc = 0;
                    if (!empty($order_items)):
                        foreach ($order_items as $index => $item):
                            $subtotal = $item['quantity'] * $item['price_at_purchase'];
                            $total_calc += $subtotal;
                            $img_src = '../assets/img/img_foods/' . $item['image_url'];
                    ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $img_src ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-2 border">
                                        <span><?= $item['food_name'] ?></span>
                                    </div>
                                </td>
                                <td class="text-center"><?= $item['quantity'] ?></td>
                                <td><?= number_format($item['price_at_purchase'], 0, ',', '.') ?>đ</td>
                                <td class="text-end fw-bold"><?= number_format($subtotal, 0, ',', '.') ?>đ</td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
                <tfoot class="bg-secondary text-dark">
                    <tr>
                        <td colspan="4" class="text-end fw-bold fs-5">TỔNG CỘNG:</td>
                        <td class="text-end fw-bold fs-5 text-danger"><?= number_format($order['total_money'], 0, ',', '.') ?>đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="bg-secondary rounded p-4">
            <h5 class="mb-3 text-dark">Cập nhật đơn hàng</h5>
            <form action="index.php?page=orderAdmin&action=updateStatus" method="POST" class="row g-3 align-items-end">
                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">

                <div class="col-md-4">
                    <label class="form-label text-dark">Trạng thái đơn hàng</label>
                    <select name="status" class="form-select text-dark">
                        <?php foreach ($status_map as $key => $label): ?>
                            <option value="<?= $label ?>" <?= $order['status'] == $label ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-dark">Gán Shipper</label>
                    <select name="shipper_id" class="form-select text-dark">
                        <option value="">-- Chưa gán shipper --</option>
                        <?php if (!empty($shippers)): ?>
                            <?php foreach ($shippers as $shipper): ?>
                                <option value="<?= $shipper['user_id'] ?>"
                                    <?= (isset($order['shipper_id']) && $order['shipper_id'] == $shipper['user_id']) ? 'selected' : '' ?>>
                                    <?= $shipper['full_name'] ?> (<?= $shipper['user_name'] ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-save me-2"></i>Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

</div>
</div>
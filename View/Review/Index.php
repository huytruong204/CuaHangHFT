<?php
// User-facing review form
?>
<div class="container" style="margin-top:80px; margin-bottom:50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading" style="background:#f78c52; color:#fff; padding:12px 16px;">
                    <h4 style="margin:0;">Đánh giá món: <?= htmlspecialchars($food->getFood_name() ?? ($food['food_name'] ?? '')) ?></h4>
                </div>
                <div class="panel-body p-4">
                    <?php if (!empty($msg_success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($msg_success) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($msg_error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($msg_error) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($errors) && is_array($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $k => $v): ?>
                                    <li><?= htmlspecialchars($v) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?page=Review&action=Create" method="POST">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($food->getFood_id() ?? ($food['food_id'] ?? '')) ?>">
                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($_GET['order_id'] ?? '') ?>">

                        <div class="mb-3">
                            <label class="form-label">Đánh giá</label>
                            <?php $oldRating = $old['rating'] ?? ($_POST['rating'] ?? ''); ?>
                            <select name="rating" class="form-select" required>
                                <option value="">-- Chọn sao --</option>
                                <?php for ($i=5; $i>=1; $i--): ?>
                                    <option value="<?= $i ?>" <?= ($oldRating !== '' && (int)$oldRating === $i) ? 'selected' : '' ?>><?= $i ?> sao</option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bình luận (tuỳ chọn)</label>
                            <?php $oldComment = $old['comment'] ?? ($_POST['comment'] ?? ''); ?>
                            <textarea name="comment" class="form-control" rows="6"><?= htmlspecialchars($oldComment) ?></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">Gửi đánh giá</button>
                            <a class="btn btn-outline-secondary" href="index.php?page=Order&action=Detail&order_id=<?= htmlspecialchars($_GET['order_id'] ?? '') ?>">Huỷ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

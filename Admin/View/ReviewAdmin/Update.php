<?php
// Admin review update form
?>
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-primary">Sửa đánh giá #<?= htmlspecialchars($review['review_id']) ?></h3>
            <div></div>
        </div>

        <form action="index.php?page=ReviewAdmin&action=UpdatePost" method="POST">
            <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['review_id']) ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Khách hàng</label>
                    <input type="text" class="form-control" disabled value="<?= htmlspecialchars($review['user_id'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Món</label>
                    <input type="text" class="form-control" disabled value="<?= htmlspecialchars($review['food_id'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Đánh giá</label>
                    <select name="rating" class="form-select">
                        <?php for ($r = 5; $r >= 1; $r--): ?>
                            <option value="<?= $r ?>" <?= (isset($review['rating']) && $review['rating'] == $r) ? 'selected' : '' ?>><?= $r ?> sao</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Bình luận</label>
                    <textarea name="comment" class="form-control" rows="6"><?= htmlspecialchars($review['comment'] ?? '') ?></textarea>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">Lưu</button>
                    <a href="index.php?page=ReviewAdmin" class="btn btn-outline-light">Hủy</a>
                </div>
            </div>
        </form>
    </div>
</div>

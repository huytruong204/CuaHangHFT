<?php
// User-facing review form
?>
<link rel="stylesheet" href="assets/css/review.css">
<div class="container review-container review">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="review-panel centered-viewport">
                <div class="review-heading">
                    <h4>Đánh giá món: <?= htmlspecialchars($food->getFood_name() ?? ($food['food_name'] ?? '')) ?></h4>
                </div>
                <div class="review-body p-4">
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

                    <?php if (!empty($mode) && $mode === 'view' && !empty($review)): ?>
                        <div class="mb-3">
                            <div class="rating-row">
                                <label class="form-label mb-0">Đã đánh giá</label>
                                <div class="star-rating" aria-label="Đánh giá của bạn">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star <?= ($i <= ($review['rating'] ?? 0)) ? 'filled' : '' ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bình luận của bạn</label>
                            <div class="border p-3 rounded bg-light text-dark min-h-120"><?= nl2br(htmlspecialchars($review['comment'] ?? '')) ?></div>
                        </div>

                        <div class="review-actions">
                            <a class="btn btn-review-primary" href="index.php?page=Review&action=Edit&review_id=<?= htmlspecialchars($review['review_id']) ?>">Sửa đánh giá</a>
                            <a class="btn btn-outline-secondary" href="index.php?page=Order&action=Detail&order_id=<?= htmlspecialchars($review['order_id']) ?>">Quay lại đơn hàng</a>
                        </div>
                    <?php else: ?>
                    <?php $formAction = (!empty($mode) && $mode === 'edit') ? 'index.php?page=Review&action=Update' : 'index.php?page=Review&action=Create'; ?>
                    <form action="<?= $formAction ?>" method="POST">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($food->getFood_id() ?? ($food['food_id'] ?? '')) ?>">
                        <?php if (!empty($mode) && $mode === 'edit' && !empty($review)): ?>
                            <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['review_id']) ?>">
                        <?php endif; ?>
                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($_GET['order_id'] ?? '') ?>">

                        <div class="mb-3">
                            <div class="rating-row">
                                <label class="form-label mb-0">Đánh giá</label>
                                <?php $oldRating = $old['rating'] ?? ($_POST['rating'] ?? ''); ?>
                                <input type="hidden" name="rating" id="rating_value" value="<?= htmlspecialchars($oldRating) ?>">
                                <div class="star-rating" role="radiogroup" aria-label="Đánh giá sao">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star" data-value="<?= $i ?>" role="radio" aria-checked="false" title="<?= $i ?> sao" tabindex="0"><?= "★" ?></span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bình luận (tuỳ chọn)</label>
                            <?php $oldComment = $old['comment'] ?? ($_POST['comment'] ?? ''); ?>
                            <textarea id="review_comment" name="comment" class="form-control" rows="6" maxlength="200" wrap="soft"><?= htmlspecialchars($oldComment) ?></textarea>
                            <div class="form-text mt-1"><span id="comment_chars">0</span>/200 ký tự</div>
                        </div>
                        <script>
                            (function(){
                                var ta = document.getElementById('review_comment');
                                var maxChars = 200;
                                var charsEl = document.getElementById('comment_chars');
                                function updateCounter(){
                                    var val = ta.value || '';
                                    var chars = val.length;
                                    charsEl.textContent = chars;
                                }
                                function enforceLimit(e){
                                    var val = ta.value || '';
                                    if(val.length > maxChars){
                                        ta.value = val.slice(0, maxChars);
                                    }
                                    updateCounter();
                                }
                                if(ta){
                                    updateCounter();
                                    ta.addEventListener('input', enforceLimit);
                                }

                                // star rating handling
                                var stars = document.querySelectorAll('.star-rating .star');
                                var hidden = document.getElementById('rating_value');
                                function setRating(v){
                                    hidden.value = v;
                                    stars.forEach(function(s){
                                        var val = parseInt(s.getAttribute('data-value'),10);
                                        if(val <= v) s.classList.add('filled'); else s.classList.remove('filled');
                                        s.setAttribute('aria-checked', val === v ? 'true' : 'false');
                                    });
                                }
                                stars.forEach(function(s){
                                    s.addEventListener('mouseover', function(){
                                        var v = parseInt(s.getAttribute('data-value'),10);
                                        stars.forEach(function(x){
                                            if(parseInt(x.getAttribute('data-value'),10) <= v) x.classList.add('hovered'); else x.classList.remove('hovered');
                                        });
                                    });
                                    s.addEventListener('mouseout', function(){
                                        stars.forEach(function(x){ x.classList.remove('hovered'); });
                                    });
                                    s.addEventListener('click', function(){
                                        var v = parseInt(s.getAttribute('data-value'),10);
                                        setRating(v);
                                    });
                                    s.addEventListener('keydown', function(ev){
                                        if(ev.key === 'Enter' || ev.key === ' '){ ev.preventDefault(); s.click(); }
                                    });
                                });
                                // initialize from existing value
                                if(hidden && hidden.value){
                                    var init = parseInt(hidden.value,10);
                                    if(!isNaN(init)) setRating(init);
                                }

                                // If we're in edit mode, prefill hidden rating value if review exists
                                <?php if (!empty($mode) && $mode === 'edit' && !empty($review)): ?>
                                (function(){
                                    var rev = <?= json_encode($review) ?>;
                                    if(rev.rating){ setRating(parseInt(rev.rating,10)); }
                                    var ta2 = document.getElementById('review_comment'); if(ta2) ta2.value = rev.comment || '';
                                    updateCounter && updateCounter();
                                })();
                                <?php endif; ?>

                                // ensure form submit has rating (guard nulls to avoid JS errors)
                                var form = document.querySelector('form');
                                if(form){
                                    form.addEventListener('submit', function(e){
                                        if(!hidden || !hidden.value || hidden.value === ''){
                                            e.preventDefault();
                                            alert('Vui lòng chọn số sao trước khi gửi đánh giá.');
                                            return false;
                                        }
                                    });
                                }
                            })();
                        </script>
                        </div>

                        <div class="review-actions">
                            <button type="submit" class="btn btn-review-primary"><?= (!empty($mode) && $mode === 'edit') ? 'Cập nhật đánh giá' : 'Gửi đánh giá' ?></button>
                            <?php if (!empty($mode) && $mode === 'edit' && !empty($review)): ?>
                                <a class="btn btn-outline-secondary" href="index.php?page=Review&product_id=<?= htmlspecialchars($review['food_id']) ?>&order_id=<?= htmlspecialchars($review['order_id']) ?>">Huỷ</a>
                            <?php else: ?>
                                <a class="btn btn-outline-secondary" href="index.php?page=Order&action=Detail&order_id=<?= htmlspecialchars($_GET['order_id'] ?? '') ?>">Huỷ</a>
                            <?php endif; ?>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

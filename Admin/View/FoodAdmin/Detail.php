<div class="pt-4 px-3">
    <div class="row justify-content-center mx-0" style="min-height: 80vh;">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 h-100"> <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <h4 class="mb-0 text-primary">
                        <i class="fa fa-info-circle me-2"></i>Chi tiết món ăn
                    </h4>
                    <a href="index.php?page=FoodAdmin<?php if(isset($_GET['p'])) echo "&p=$_GET[p]"?>" class="btn btn-outline-primary btn-sm">
                        <i class="fa fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                </div>

                <div class="row g-5">
                    <div class="col-md-5">
                        <div class="position-relative text-center rounded p-3 h-100 d-flex align-items-center justify-content-center border shadow-sm">
                            <img src="../assets/img/img_foods/<?= $food->getImage_url() ?>"
                                 class="img-fluid rounded"
                                 alt="<?= $food->getFood_name() ?>"
                                 style="max-height: 400px; width: 100%; object-fit: cover;">

                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-primary fs-6 shadow-sm">ID: <?= $food->getFood_id() ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="h-100 d-flex flex-column">
                            
                            <div class="mb-3">
                                <span class="badge bg-warning text-dark mb-2">
                                    <i class="fa fa-tags me-1"></i><?= $food->getCategory_id() ?>
                                </span>
                                <h2 class="text-dark fw-bold"><?= $food->getFood_name() ?></h2>
                            </div>

                            <div class="d-flex align-items-center mb-4 p-3 rounded border">
                                <h3 class="text-danger mb-0 me-4 fw-bold">  
                                    <?= number_format($food->getPrice(), 0, ',', '.') ?> VNĐ
                                </h3>
                                
                                <?php if ($food->getStatus() == 1): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        <i class="fa fa-check-circle me-1"></i>Đang bán
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                        <i class="fa fa-times-circle me-1"></i>Ngừng bán
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size: 0.85rem;">Mô tả chi tiết:</h6>
                                <div class="p-3 rounded border text-secondary" style="min-height: 100px;">
                                    <?= nl2br($food->getDescription()) ?>
                                </div>
                            </div>

                            <div class="mt-auto mb-4 text-muted small fst-italic">
                                <i class="fa fa-calendar-alt me-1"></i> Ngày tạo: <?= date('d/m/Y H:i', strtotime($food->getCreated_at())) ?>
                            </div>

                            <div class="d-flex gap-3">
                                <a href="index.php?page=FoodAdmin&action=UpdateGet&food_id=<?= $food->getFood_id() ?>" 
                                   class="btn btn-warning flex-grow-1 fw-bold">
                                    <i class="fa fa-pen me-2"></i>Cập nhật thông tin
                                </a>
                                
                                <form action="index.php?page=FoodAdmin&action=Delete" method="POST" class="flex-grow-1">
                                    <input type="hidden" name="food_id" value="<?= $food->getFood_id() ?>">
                                    <button type="submit" class="btn btn-danger w-100 fw-bold"
                                            onclick="return confirm('CẢNH BÁO: Bạn có chắc chắn muốn xóa món này không? Hành động này không thể hoàn tác!');">
                                        <i class="fa fa-trash me-2"></i>Xóa món ăn
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


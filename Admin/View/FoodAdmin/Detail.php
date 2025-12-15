<div class="container-fluid pt-4 px-3 ">
    <div class="row justify-content-center mx-0" style="min-height: 80vh;">
        <div class="col-12 ">
            <div class="bg-secondary rounded p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 text-primary">Chi tiết món ăn: <?= $food->getFood_name() ?></h4>
                    <a href="index.php?page=FoodAdmin" class="btn btn-outline-light btn-sm">
                        <i class="fa fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                </div>
                <div class="row g-4">
                    <div class="col-md-5">
                        <div class="position-relative text-center bg-dark rounded p-3 h-100 d-flex align-items-center justify-content-center">
                            <img src="../assets/img/img_foods/<?php echo $food->getImage_url() ?>"
                                class="img-fluid rounded shadow-sm"
                                style="max-height: 400px; width: 100%; object-fit: cover;">

                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-primary fs-6">ID: <?= $food->getFood_id() ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="h-100 d-flex flex-column">

                            <div class="mb-3">
                                <small class="text-muted text-uppercase fw-bold">Danh mục: <?= $food->getCategory_id() ?></small>
                                <h2 class="mt-2 text-white"><?= $food->getFood_name() ?></h2>
                            </div>

                            <div class="d-flex align-items-center mb-4">
                                <h3 class="text-primary mb-0 me-3 fw-bold"><?= $price_format ?></h3>
                                <?= $status_badge ?>
                            </div>

                            <hr class="border-gray-700">

                            <div class="mb-4">
                                <h6 class="text-white-50 mb-2">Mô tả chi tiết / Thành phần:</h6>
                                <p class="text-light" style="line-height: 1.6;">
                                    <?= nl2br($food->getDescription()) ?>
                                </p>
                            </div>

                            <div class="mt-auto p-3 bg-dark rounded">
                                <div class="row text-muted fst-italic" style="font-size: 0.9rem;">
                                    <div class="col-12">
                                        <i class="fa fa-calendar me-2"></i>Ngày tạo:<br>
                                        <span class="text-white"><?= $food->getCreated_at() ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 d-flex gap-2">
                                <a href="index.php?page=FoodAdmin&action=UpdateGet&food_id=<?= $food->getFood_id() ?>" class="btn btn-warning">
                                    Cập nhật
                                </a>
                                <form action='index.php?page=FoodAdmin&action=Delete&food_id=<?= $food->getFood_id() ?>' method='POST'>
                                    <input type='hidden' name='food_id' value='<?= $food->getFood_id() ?>'>
                                    <button type='submit' class='btn btn-danger'
                                        onclick="return confirm('Bạn có chắc muốn xóa món này không?');">
                                        Xóa
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
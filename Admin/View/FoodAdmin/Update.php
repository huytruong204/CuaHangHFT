<div class="col-12 pt-4 px-4">
    <div class="bg-secondary rounded h-100 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0">Cập nhật Món Ăn</h6>
            <a href="index.php?page=FoodAdmin" class="btn btn-outline-light btn-sm">Quay lại</a>
        </div>

        <form action="index.php?page=FoodAdmin&action=UpdatePost" method="POST" enctype="multipart/form-data">
            <div class="row">
                
                <div class="col-md-4 d-flex flex-column align-items-center justify-content-start text-center">
                    <label class="form-label fw-bold mb-3">Hình ảnh</label>
                    <div class="mb-3 d-flex align-items-center justify-content-center bg-dark rounded" 
                         style="width: 100%; object-fit: cover; border: 2px dashed #6c757d; overflow: hidden; position: relative;">
                        <img src="../assets/img/img_foods/<?php echo $food->getImage_url()?>" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 400px; width: 100%; object-fit: cover;">
                    </div>
                    <input class="form-control bg-dark mb-2" type="file" id="imageInput" name="image_url" accept="image/*">
                    <small class="text-muted fst-italic">Để trống nếu không muốn thay đổi ảnh</small>
                    <input type="hidden" name="old_image" value="<?= $food->getImage_url() ?>">
                    <span class="text-danger small">
                                <?php if (isset($errors['image_url'])) echo  $errors["image_url"] ?>
                    </span>
                </div>

                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-dark text-muted" id="foodId" name="food_id" 
                                       value="<?= $food->getFood_id() ?>" readonly> <label for="foodId">Mã món ăn</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select bg-dark" id="categorySelect" name="category_id">
                                    <option value="1" <?= ($food->getCategory_id() == '1') ? 'selected' : '' ?>>Đồ uống</option>
                                </select>
                                <label for="categorySelect">Danh mục</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-dark" id="foodName" name="food_name" 
                                       value="<?= $food->getFood_name() ?>" >
                                <label for="foodName">Tên món ăn</label>
                            </div>
                            <span class="text-danger small">
                                <?php if (isset($errors['food_name'])) echo  $errors["food_name"] ?>
                            </span>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="form-floating" style="flex-grow: 1;">
                                    <input type="number" class="form-control bg-dark" id="price" name="price" 
                                           value="<?= $food->getPrice() ?>" min="0">
                                    <label for="price">Giá bán</label>
                                </div>
                                <span class="input-group-text bg-dark text-white border-secondary">VNĐ</span>
                            </div>
                            <span class="text-danger small">
                                <?php if (isset($errors['price'])) echo $errors["price"] ?>
                            </span>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select bg-dark" id="status" name="status">
                                    <option value="1" <?= ($food->getStatus() == 1) ? 'selected' : '' ?> class="text-success">Đang bán (Active)</option>
                                    <option value="0" <?= ($food->getStatus() == 0) ? 'selected' : '' ?> class="text-danger">Ngừng bán (Inactive)</option>
                                </select>
                                <label for="status">Trạng thái</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control bg-dark" placeholder="Mô tả" name="description" id="description" 
                                          style="height: 120px;"><?= $food->getDescription() ?></textarea>
                                <label for="description">Mô tả chi tiết</label>
                            </div>
                            <span class="text-danger small">
                                <?php if (isset($errors['description'])) echo  $errors["description"] ?>
                            </span>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-warning py-3 w-100 fw-bold text-dark">
                               </i>Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

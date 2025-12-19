
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded h-100 p-4"> <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0 text-primary">Cập nhật Món Ăn</h6>
            <a href="index.php?page=FoodAdmin<?php if(isset($_GET['p'])) echo "&p=$_GET[p]"?>" class="btn btn-outline-primary btn-sm">
                <i class="fa fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>

        <form action="index.php?page=FoodAdmin&action=UpdatePost" method="POST" enctype="multipart/form-data">
            <div class="row">
                
                <div class="col-md-4 d-flex flex-column align-items-center justify-content-start text-center">
                    <label class="form-label fw-bold mb-3">Hình ảnh</label>
                    
                    <div class="mb-3 d-flex align-items-center justify-content-center  rounded" 
                         style="width: 100%; height: 300px; border: 2px dashed #ced4da; overflow: hidden; position: relative;">
                        <img id="imgPreview" 
                             src="../assets/img/img_foods/<?= $food->getImage_url() ?>" 
                             class="img-fluid" 
                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>

                    <input class="form-control mb-2" type="file" id="imageInput" name="image_url" accept="image/*" onchange="previewImage(this)">
                    <small class="text-muted fst-italic">Để trống nếu giữ nguyên ảnh cũ</small>
                    
                    <input type="hidden" name="old_image" value="<?= $food->getImage_url() ?>">
                    
                    <?php if (isset($errors['image_url'])): ?>
                        <span class="text-danger small mt-1"><?= $errors['image_url'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control text-muted" id="foodId" name="food_id" 
                                       value="<?= $food->getFood_id() ?>" readonly> 
                                <label for="foodId">Mã món ăn (Không thể sửa)</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="categorySelect" name="category_id">
                                <?php
                                        foreach ($list_cat as $cat) {
                                            $selected = '';
                                            if(isset($_POST['category_id']) && $_POST['category_id']== $cat->getCategory_id()){
                                                $selected = "selected";
                                            }
                                            else{
                                                $selected = ($food->getCategory_id() == $cat->getCategory_name())  ? "selected" : "";
                                            }
                                            echo "
                                                <option value='{$cat->getCategory_id()}' $selected >{$cat->getCategory_name()}</option>
                                                
                                            ";
                                        }
                                    ?>
                                </select>
                                
                                <label for="categorySelect">Danh mục</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="foodName" name="food_name" 
                                       value="<?= $food->getFood_name() ?>" required>
                                <label for="foodName">Tên món ăn</label>
                            </div>
                            <?php if (isset($errors['food_name'])): ?>
                                <span class="text-danger small ms-1"><?= $errors['food_name'] ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="form-floating" style="flex-grow: 1;">
                                    <input type="number" class="form-control" id="price" name="price" 
                                           value="<?= $food->getPrice() ?>" min="0">
                                    <label for="price">Giá bán</label>
                                </div>
                                <span class="input-group-text  text-dark border">VNĐ</span>
                            </div>
                            <?php if (isset($errors['price'])): ?>
                                <span class="text-danger small ms-1"><?= $errors['price'] ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="status" name="status">
                                    <option value="1" <?= ($food->getStatus() == 1) ? 'selected' : '' ?> class="text-success fw-bold">Đang bán (Active)</option>
                                    <option value="0" <?= ($food->getStatus() == 0) ? 'selected' : '' ?> class="text-danger fw-bold">Ngừng bán (Inactive)</option>
                                </select>
                                <label for="status">Trạng thái</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Mô tả" name="description" id="description" 
                                          style="height: 120px;"><?= $food->getDescription() ?></textarea>
                                <label for="description">Mô tả chi tiết</label>
                            </div>
                            <?php if (isset($errors['description'])): ?>
                                <span class="text-danger small ms-1"><?= $errors['description'] ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-warning py-3 w-100 fw-bold text-dark">
                                <i class="fa fa-save me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        var preview = document.getElementById('imgPreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result; 
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


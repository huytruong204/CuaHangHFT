<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded h-100 p-4"> <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0 text-primary">Thêm Món Ăn Mới</h6>
            <a href="index.php?page=FoodAdmin<?php if(isset($_GET['p'])) echo "&p=$_GET[p]"?>" class="btn btn-outline-primary btn-sm">
                <i class="fa fa-arrow-left me-2"></i>Quay lại danh sách
            </a>
        </div>

        <form action="index.php?page=FoodAdmin&action=CreatePost" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4 d-flex flex-column align-items-center justify-content-start text-center">
                    <label class="form-label fw-bold mb-3 text-dark">Hình ảnh món ăn</label>
                    
                    <div class="image-preview-container mb-3 d-flex align-items-center justify-content-center rounded" 
                         style="width: 100%; height: 250px; border: 2px dashed #ccc; overflow: hidden;">
                        <img id="imgPreview" src="#" alt="Xem trước" class="d-none" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                        <div id="placeholderText" class="text-muted">
                            <i class="fa fa-cloud-upload-alt fa-3x mb-2"></i><br>Chọn ảnh
                        </div>
                    </div>

                    <input class="form-control mb-2" type="file" id="imageInput" name="image_url" accept="image/*" onchange="previewImage(this)">
                    <small class="text-muted fst-italic">* Định dạng: jpg, png, jpeg</small>
                    
                    <?php if (isset($errors['image_url'])): ?>
                        <span class="text-danger small mt-2"><?= $errors['image_url'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="foodId" name="food_id" 
                                       value="Auto" readonly>
                                <label for="foodId">Mã món ăn</label>
                            </div>
                            <?php if (isset($errors['food_id'])): ?>
                                <span class="text-danger small"><?= $errors['food_id'] ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="categorySelect" name="category_id">
                                    <?php
                                        foreach ($list_cat as $cat) {
                                            $selected = isset($_POST['category_id']) && $_POST['category_id']== $cat->getCategory_id() ? 'selected' : '';
                                            echo "
                                                <option value='{$cat->getCategory_id()}' ) $selected >{$cat->getCategory_name()}</option>

                                            ";
                                        }
                                    ?>
                                </select>
                                <label for="categorySelect">Danh mục</label>
                            </div>
                            <?php if (isset($errors['category_id'])): ?>
                                <span class="text-danger small"><?= $errors['category_id'] ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="foodName" name="food_name" 
                                       value="<?php echo $_POST['food_name'] ?? '' ?>" placeholder="Tên món" >
                                <label for="foodName">Tên món ăn</label>
                            </div>
                            <?php if (isset($errors['food_name'])): ?>
                                <span class="text-danger small"><?= $errors['food_name'] ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="form-floating" style="flex-grow: 1;">
                                    <input type="number" class="form-control" id="price" name="price" 
                                           value="<?php echo $_POST['price'] ?? '' ?>" placeholder="Giá" min="0">
                                    <label for="price">Giá bán</label>
                                </div>
                                <span class="input-group-text  text-dark border">VNĐ</span>
                            </div>
                            <?php if (isset($errors['price'])): ?>
                                <span class="text-danger small"><?= $errors['price'] ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="status" name="status">
                                    <option value="1" selected class="text-success">Đang bán</option>
                                    <option value="0" class="text-danger">Hết hàng</option>
                                </select>
                                <label for="status">Trạng thái</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Mô tả" name="description" id="description" 
                                          style="height: 120px;"><?php echo $_POST['description'] ?? '' ?></textarea>
                                <label for="description">Mô tả chi tiết / Thành phần</label>
                            </div>
                            <?php if (isset($errors['description'])): ?>
                                <span class="text-danger small"><?= $errors['description'] ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary py-3 w-100 fw-bold">
                                <i class="fa fa-save me-2"></i>Lưu Món Ăn
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
        var placeholder = document.getElementById('placeholderText');
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "#";
            preview.classList.add('d-none');
            placeholder.classList.remove('d-none');
        }
    }
</script>

<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded h-100 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Thêm Món Ăn Mới</h3>
            <a href="index.php?page=FoodAdmin" class="btn btn-outline-light btn-sm">
                <i class="fa fa-arrow-left me-2"></i>Quay lại danh sách
            </a>
        </div>
        <form action="index.php?page=FoodAdmin&action=CreatePost" method="POST" enctype="multipart/form-data">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-dark" id="foodId" name="food_id" value="Auto" readonly>
                                <label for="foodId">Mã món ăn </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select bg-dark" id="categorySelect" name="category_id">
                                    <option value="1">Đồ uống</option>
                                </select>
                                <label for="categorySelect">Danh mục</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-dark" id="foodName" name="food_name" value="<?php if (isset($_POST['food_name'])) echo $_POST['food_name'] ?>" placeholder="Tên món">
                                <label for="foodName">Tên món ăn</label>
                            </div>
                            <span class="text-danger small">
                                <?php if (isset($errors['food_name'])) echo  $errors["food_name"] ?>
                            </span>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="form-floating" style="flex-grow: 1;">
                                    <input type="number" class="form-control bg-dark" id="price" name="price" value="<?php if (isset($_POST['price'])) echo $_POST['price'] ?>" placeholder="Giá" min="0">
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
                                    <option value="1" class="text-success">Đang bán </option>
                                    <option value="0" class="text-danger">Ngừng bán</option>
                                </select>
                                <label for="status">Trạng thái</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <input class="form-control bg-dark mb-3" type="file" id="imageInput" name="image_url" accept="image/*">
                            <span class="text-danger small">
                                <?php if (isset($errors['image_url'])) echo  $errors["image_url"] ?>
                            </span>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control bg-dark" name="description" id="description" style="height:120px;"><?php if (isset($_POST['description'])) echo $_POST['description'] ?></textarea>
                                <label for="description">Mô tả chi tiết</label>
                            </div>
                            <span class="text-danger small">
                                <?php if (isset($errors['description'])) echo  $errors["description"] ?>
                            </span>
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
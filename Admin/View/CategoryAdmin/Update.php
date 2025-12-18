
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded h-100 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0 text-primary">Cập nhật Danh Mục</h6>
            <a href="index.php?page=CategoryAdmin<?php if(isset($_GET['p'])) echo "&p=$_GET[p]"?>" class="btn btn-outline-primary btn-sm">
                <i class="fa fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>

        <form action="index.php?page=CategoryAdmin&action=UpdatePost" method="POST" enctype="multipart/form-data">
            <div class="row">   
                <div class="col-md-12">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control text-muted" id="categoryId" name="category_id" 
                                       value="<?= $category->getCategory_id() ?>" readonly> 
                                <label for="categoryId">Mã danh mục (Không thể sửa)</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="categoryName" name="category_name" 
                                       value="<?= $category->getCategory_name() ?>" required>
                                <label for="categoryName">Tên danh mục</label>
                            </div>
                            <?php if (isset($errors['category_name'])): ?>
                                <span class="text-danger small ms-1"><?= $errors['category_name'] ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Mô tả" name="description" id="description" 
                                          style="height: 120px;"><?= $category->getDescription() ?></textarea>
                                <label for="description">Mô tả danh mục</label>
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

<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <a href="index.php">Trang chủ</a> <span>/</span> <strong>Quên mật khẩu</strong>
            </div>
        </div>
    </div>
</section>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel panel-default card-box">
                    <h3 class="card-title">Quên mật khẩu</h3>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <form method="post" action="index.php?page=Auth&action=forgotPassword">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="Nhập email đã đăng ký">
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary" type="submit">Gửi liên kết đặt lại</button>
                            <a href="index.php?page=SignIn" class="btn btn-link">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
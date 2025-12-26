<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <a href="index.php">Trang chủ</a> <span>/</span> <strong>Đặt lại mật khẩu</strong>
            </div>
        </div>
    </div>
</section>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel panel-default card-box">
                    <h3 class="card-title">Đặt lại mật khẩu</h3>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <?php if (empty($error) || $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                        <form method="post" action="index.php?page=Auth&action=resetPassword">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                            <div class="form-group">
                                <label for="password">Mật khẩu mới</label>
                                <input type="password" name="password" id="password" class="form-control" required placeholder="Mật khẩu mới">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Xác nhận mật khẩu</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required placeholder="Xác nhận mật khẩu">
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary" type="submit">Đặt lại mật khẩu</button>
                                <a href="index.php?page=SignIn" class="btn btn-link">Hủy</a>
                            </div>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>
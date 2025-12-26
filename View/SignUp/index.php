<section class="signup-section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="panel panel-default mx-auto auth-panel signup">
          <div class="text-center mb-3">
            <h2>Đăng ký tài khoản</h2> <br>
          </div>

          <?php if (!empty($error_message) || !empty($errors) || !empty($register_error)): ?>
            <div class="alert alert-danger">
              <?php
              if (!empty($register_error)) echo $register_error;
              elseif (!empty($error_message)) echo $error_message;
              elseif (!empty($errors) && is_array($errors)) echo implode('<br>', $errors);
              ?>
            </div>
          <?php endif; ?>

          <form action="index.php?page=SignUp&action=register" method="post" enctype="multipart/form-data" novalidate>
            <div class="row">
              <div class="col-md-4 text-center avatar-section">
                <div class="avatar-wrapper">
                  <img id="avatar_preview" class="avatar-preview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Ccircle cx='100' cy='100' r='100' fill='%23e9ecef'/%3E%3C/svg%3E" alt="Avatar preview">
                  <input type="file" id="avatar_url" name="avatar_url" accept="image/*" style="display:none">
                </div>
                <p class="avatar-hint">Nhấn để chọn ảnh đại diện</p>

              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="user_name">Tài khoản</label>
                      <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Tên đăng nhập" required value="<?= htmlspecialchars($_POST['user_name'] ?? '') ?>">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="full_name">Họ và tên</label>
                      <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Họ và tên" required value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="password">Mật khẩu</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="confirm_password">Xác nhận mật khẩu</label>
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div class="form-group">
                  <label for="phone_number">Số điện thoại</label>
                  <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Số điện thoại" required value="<?= htmlspecialchars($_POST['phone_number'] ?? '') ?>">
                </div>

                <div class="form-group">
                  <label for="address">Địa chỉ</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ" required value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
                </div>

                <div class="form-group">
                  <label for="city">Tỉnh/Thành phố</label>
                  <?php $selectedCity = $_POST['city'] ?? ''; ?>
                  <?php $cities = include __DIR__ . '/../../assets/data/cities.php'; ?>
                  <select class="form-control" id="city" name="city" required>
                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                    <?php foreach ($cities as $c): ?>
                      <option value="<?= htmlspecialchars($c) ?>" <?= $selectedCity === $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Tạo tài khoản</button>

                <div class="text-center mt-3">
                  <small>Đã có tài khoản? <a href="index.php?page=SignIn">Đăng nhập</a></small>
                </div>
              </div>
            </div>
          </form>

          <script>
            document.addEventListener('DOMContentLoaded', function() {
              const avatarInput = document.getElementById('avatar_url');
              const avatarPreview = document.getElementById('avatar_preview');
              const avatarWrapper = document.querySelector('.avatar-wrapper');

              console.log('Avatar elements:', {
                avatarInput,
                avatarPreview,
                avatarWrapper
              }); // Debug

              if (!avatarInput || !avatarWrapper) {
                console.error('Không tìm thấy avatar elements');
                return;
              }

              avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                  const reader = new FileReader();
                  reader.onload = function(event) {
                    avatarPreview.src = event.target.result;
                  };
                  reader.readAsDataURL(file);
                }
              });

              // Click vào wrapper để mở file picker
              avatarWrapper.addEventListener('click', function(e) {
                console.log('Avatar wrapper clicked'); // Debug
                avatarInput.click();
              });
            });
          </script>
        </div>
      </div>
    </div>
  </div>
</section>
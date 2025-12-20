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
                      <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Tên đăng nhập" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="full_name">Họ và tên</label>
                      <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Họ và tên" required>
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
                  <label for="phone_number">Số điện thoại</label>
                  <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Số điện thoại" required>
                </div>

                <div class="form-group">
                  <label for="address">Địa chỉ</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ" required>
                </div>

                <div class="form-group">
                  <label for="city">Tỉnh/Thành phố</label>
                  <?php $selectedCity = $_POST['city'] ?? '';?>
                  <select class="form-control" id="city" name="city" required>
                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                    <option value="Hà Nội" <?= $selectedCity === 'Hà Nội' ? 'selected' : '' ?>>Hà Nội</option>
                    <option value="TP. Hồ Chí Minh" <?= $selectedCity === 'TP. Hồ Chí Minh' ? 'selected' : '' ?>>TP. Hồ Chí Minh</option>
                    <option value="An Giang" <?= $selectedCity === 'An Giang' ? 'selected' : '' ?>>An Giang</option>
                    <option value="Bà Rịa–Vũng Tàu" <?= $selectedCity === 'Bà Rịa–Vũng Tàu' ? 'selected' : '' ?>>Bà Rịa–Vũng Tàu</option>
                    <option value="Bắc Giang" <?= $selectedCity === 'Bắc Giang' ? 'selected' : '' ?>>Bắc Giang</option>
                    <option value="Bắc Kạn" <?= $selectedCity === 'Bắc Kạn' ? 'selected' : '' ?>>Bắc Kạn</option>
                    <option value="Bạc Liêu" <?= $selectedCity === 'Bạc Liêu' ? 'selected' : '' ?>>Bạc Liêu</option>
                    <option value="Bắc Ninh" <?= $selectedCity === 'Bắc Ninh' ? 'selected' : '' ?>>Bắc Ninh</option>
                    <option value="Bến Tre" <?= $selectedCity === 'Bến Tre' ? 'selected' : '' ?>>Bến Tre</option>
                    <option value="Bình Định" <?= $selectedCity === 'Bình Định' ? 'selected' : '' ?>>Bình Định</option>
                    <option value="Bình Dương" <?= $selectedCity === 'Bình Dương' ? 'selected' : '' ?>>Bình Dương</option>
                    <option value="Bình Phước" <?= $selectedCity === 'Bình Phước' ? 'selected' : '' ?>>Bình Phước</option>
                    <option value="Bình Thuận" <?= $selectedCity === 'Bình Thuận' ? 'selected' : '' ?>>Bình Thuận</option>
                    <option value="Cà Mau" <?= $selectedCity === 'Cà Mau' ? 'selected' : '' ?>>Cà Mau</option>
                    <option value="Cần Thơ" <?= $selectedCity === 'Cần Thơ' ? 'selected' : '' ?>>Cần Thơ</option>
                    <option value="Cao Bằng" <?= $selectedCity === 'Cao Bằng' ? 'selected' : '' ?>>Cao Bằng</option>
                    <option value="Đà Nẵng" <?= $selectedCity === 'Đà Nẵng' ? 'selected' : '' ?>>Đà Nẵng</option>
                    <option value="Đắk Lắk" <?= $selectedCity === 'Đắk Lắk' ? 'selected' : '' ?>>Đắk Lắk</option>
                    <option value="Đắk Nông" <?= $selectedCity === 'Đắk Nông' ? 'selected' : '' ?>>Đắk Nông</option>
                    <option value="Điện Biên" <?= $selectedCity === 'Điện Biên' ? 'selected' : '' ?>>Điện Biên</option>
                    <option value="Đồng Nai" <?= $selectedCity === 'Đồng Nai' ? 'selected' : '' ?>>Đồng Nai</option>
                    <option value="Đồng Tháp" <?= $selectedCity === 'Đồng Tháp' ? 'selected' : '' ?>>Đồng Tháp</option>
                    <option value="Gia Lai" <?= $selectedCity === 'Gia Lai' ? 'selected' : '' ?>>Gia Lai</option>
                    <option value="Hà Giang" <?= $selectedCity === 'Hà Giang' ? 'selected' : '' ?>>Hà Giang</option>
                    <option value="Hà Nam" <?= $selectedCity === 'Hà Nam' ? 'selected' : '' ?>>Hà Nam</option>
                    <option value="Hà Tĩnh" <?= $selectedCity === 'Hà Tĩnh' ? 'selected' : '' ?>>Hà Tĩnh</option>
                    <option value="Hải Dương" <?= $selectedCity === 'Hải Dương' ? 'selected' : '' ?>>Hải Dương</option>
                    <option value="Hải Phòng" <?= $selectedCity === 'Hải Phòng' ? 'selected' : '' ?>>Hải Phòng</option>
                    <option value="Hậu Giang" <?= $selectedCity === 'Hậu Giang' ? 'selected' : '' ?>>Hậu Giang</option>
                    <option value="Hòa Bình" <?= $selectedCity === 'Hòa Bình' ? 'selected' : '' ?>>Hòa Bình</option>
                    <option value="Hưng Yên" <?= $selectedCity === 'Hưng Yên' ? 'selected' : '' ?>>Hưng Yên</option>
                    <option value="Khánh Hòa" <?= $selectedCity === 'Khánh Hòa' ? 'selected' : '' ?>>Khánh Hòa</option>
                    <option value="Kiên Giang" <?= $selectedCity === 'Kiên Giang' ? 'selected' : '' ?>>Kiên Giang</option>
                    <option value="Kon Tum" <?= $selectedCity === 'Kon Tum' ? 'selected' : '' ?>>Kon Tum</option>
                    <option value="Lai Châu" <?= $selectedCity === 'Lai Châu' ? 'selected' : '' ?>>Lai Châu</option>
                    <option value="Lâm Đồng" <?= $selectedCity === 'Lâm Đồng' ? 'selected' : '' ?>>Lâm Đồng</option>
                    <option value="Lạng Sơn" <?= $selectedCity === 'Lạng Sơn' ? 'selected' : '' ?>>Lạng Sơn</option>
                    <option value="Lào Cai" <?= $selectedCity === 'Lào Cai' ? 'selected' : '' ?>>Lào Cai</option>
                    <option value="Long An" <?= $selectedCity === 'Long An' ? 'selected' : '' ?>>Long An</option>
                    <option value="Nam Định" <?= $selectedCity === 'Nam Định' ? 'selected' : '' ?>>Nam Định</option>
                    <option value="Nghệ An" <?= $selectedCity === 'Nghệ An' ? 'selected' : '' ?>>Nghệ An</option>
                    <option value="Ninh Bình" <?= $selectedCity === 'Ninh Bình' ? 'selected' : '' ?>>Ninh Bình</option>
                    <option value="Ninh Thuận" <?= $selectedCity === 'Ninh Thuận' ? 'selected' : '' ?>>Ninh Thuận</option>
                    <option value="Phú Thọ" <?= $selectedCity === 'Phú Thọ' ? 'selected' : '' ?>>Phú Thọ</option>
                    <option value="Phú Yên" <?= $selectedCity === 'Phú Yên' ? 'selected' : '' ?>>Phú Yên</option>
                    <option value="Quảng Bình" <?= $selectedCity === 'Quảng Bình' ? 'selected' : '' ?>>Quảng Bình</option>
                    <option value="Quảng Nam" <?= $selectedCity === 'Quảng Nam' ? 'selected' : '' ?>>Quảng Nam</option>
                    <option value="Quảng Ngãi" <?= $selectedCity === 'Quảng Ngãi' ? 'selected' : '' ?>>Quảng Ngãi</option>
                    <option value="Quảng Ninh" <?= $selectedCity === 'Quảng Ninh' ? 'selected' : '' ?>>Quảng Ninh</option>
                    <option value="Quảng Trị" <?= $selectedCity === 'Quảng Trị' ? 'selected' : '' ?>>Quảng Trị</option>
                    <option value="Sóc Trăng" <?= $selectedCity === 'Sóc Trăng' ? 'selected' : '' ?>>Sóc Trăng</option>
                    <option value="Sơn La" <?= $selectedCity === 'Sơn La' ? 'selected' : '' ?>>Sơn La</option>
                    <option value="Tây Ninh" <?= $selectedCity === 'Tây Ninh' ? 'selected' : '' ?>>Tây Ninh</option>
                    <option value="Thái Bình" <?= $selectedCity === 'Thái Bình' ? 'selected' : '' ?>>Thái Bình</option>
                    <option value="Thái Nguyên" <?= $selectedCity === 'Thái Nguyên' ? 'selected' : '' ?>>Thái Nguyên</option>
                    <option value="Thanh Hóa" <?= $selectedCity === 'Thanh Hóa' ? 'selected' : '' ?>>Thanh Hóa</option>
                    <option value="Thừa Thiên Huế" <?= $selectedCity === 'Thừa Thiên Huế' ? 'selected' : '' ?>>Thừa Thiên Huế</option>
                    <option value="Tiền Giang" <?= $selectedCity === 'Tiền Giang' ? 'selected' : '' ?>>Tiền Giang</option>
                    <option value="Trà Vinh" <?= $selectedCity === 'Trà Vinh' ? 'selected' : '' ?>>Trà Vinh</option>
                    <option value="Tuyên Quang" <?= $selectedCity === 'Tuyên Quang' ? 'selected' : '' ?>>Tuyên Quang</option>
                    <option value="Vĩnh Long" <?= $selectedCity === 'Vĩnh Long' ? 'selected' : '' ?>>Vĩnh Long</option>
                    <option value="Vĩnh Phúc" <?= $selectedCity === 'Vĩnh Phúc' ? 'selected' : '' ?>>Vĩnh Phúc</option>
                    <option value="Yên Bái" <?= $selectedCity === 'Yên Bái' ? 'selected' : '' ?>>Yên Bái</option>
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
            document.addEventListener('DOMContentLoaded', function(){
              const avatarInput = document.getElementById('avatar_url');
              const avatarPreview = document.getElementById('avatar_preview');
              const avatarWrapper = document.querySelector('.avatar-wrapper');
              
              console.log('Avatar elements:', {avatarInput, avatarPreview, avatarWrapper}); // Debug
              
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
              avatarWrapper.addEventListener('click', function(e){
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



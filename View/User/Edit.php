<section id="center" class="center_shop clearfix">
	<div class="container">
		<div class="row">
			<div class="center_shop_1 clearfix">
				<div class="col-sm-12">
					<h2 class="mgt head_1"><i class="fa fa-edit"></i> Chỉnh Sửa Hồ Sơ</h2>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="profile-edit" class="clearfix">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Cập Nhật Thông Tin Cá Nhân</h3>
					</div>
					<div class="panel-body">
                        
						<?php if (!empty($errors) && is_array($errors)): ?>
							<div class="alert alert-danger">
								<?= implode('<br>', $errors) ?>
							</div>
						<?php endif; ?>
                        
						<?php if (SessionManager::exists('success')): ?>
							<div class="alert alert-success">
								<?= SessionManager::flash('success') ?>
							</div>
						<?php endif; ?>

						<form action="index.php?page=User&action=Update" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-sm-4 text-center">
									<div class="avatar-wrapper" style="cursor: pointer;">
										<?php if (!empty($user) && !empty($user->getAvatar_url())): ?>
											<img id="avatar_preview" src="assets/img/avatars/<?= htmlspecialchars($user->getAvatar_url()) ?>" 
												 alt="Avatar" class="img-thumbnail" style="max-width: 150px;">
										<?php else: ?>
											<img id="avatar_preview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Ccircle cx='100' cy='100' r='100' fill='%23e9ecef'/%3E%3C/svg%3E" 
												 alt="Avatar" class="img-thumbnail" style="max-width: 150px;">
										<?php endif; ?>
									</div>
									<input type="file" id="avatar_url" name="avatar_url" accept="image/*" style="display:none">
									<p class="text-muted" style="margin-top: 10px;">Nhấn vào ảnh để thay đổi</p>
								</div>
                                
								<div class="col-sm-8">
									<div class="form-group">
										<label for="user_name">Tên đăng nhập</label>
										<input type="text" class="form-control" id="user_name" 
											   value="<?= htmlspecialchars($user->getUser_name() ?? '') ?>" disabled>
										<small class="text-muted">Tên đăng nhập không thể thay đổi</small>
									</div>

									<div class="form-group">
										<label for="full_name">Họ và tên <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="full_name" name="full_name" 
											   value="<?= htmlspecialchars($user->getFull_name() ?? '') ?>" required>
									</div>

									<div class="form-group">
										<label for="phone_number">Số điện thoại <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="phone_number" name="phone_number" 
											   value="<?= htmlspecialchars($user->getPhone_number() ?? '') ?>" required>
									</div>

									<div class="form-group">
										<label for="address">Địa chỉ <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="address" name="address" 
											   value="<?= htmlspecialchars($user->getAddress() ?? '') ?>" required>
									</div>

									<div class="form-group">
										<label for="city">Tỉnh/Thành phố <span class="text-danger">*</span></label>
										<?php $selectedCity = $user->getCity() ?? ''; ?>
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

							<div class="row" style="margin-top: 20px;">
								<div class="col-sm-12">
									<button type="submit" class="btn btn-primary">
										<i class="fa fa-save"></i> Lưu thay đổi
									</button>
									<a href="index.php?page=User" class="btn btn-default">
										<i class="fa fa-times"></i> Hủy
									</a>
								</div>
							</div>
						</form>

						<script>
							document.addEventListener('DOMContentLoaded', function(){
								const avatarInput = document.getElementById('avatar_url');
								const avatarPreview = document.getElementById('avatar_preview');
								const avatarWrapper = document.querySelector('.avatar-wrapper');
                                
								if (!avatarInput || !avatarWrapper) return;

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

								avatarWrapper.addEventListener('click', function(){
									avatarInput.click();
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
.panel-heading { background-color: #f5f5f5; border-bottom: 2px solid #e74c3c; }
.panel-title { font-weight: bold; font-size: 18px; }
.avatar-wrapper { margin-bottom: 15px; }
.avatar-wrapper img { cursor: pointer; transition: opacity 0.3s; }
.avatar-wrapper img:hover { opacity: 0.8; }
</style>


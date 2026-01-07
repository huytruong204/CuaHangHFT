<?php if (!empty($msg)): ?>
	<div id="cart-notification" class="success-popup">
		<div class="popup-content">
			<div class="icon-box"><span>&#10003;</span></div>
			<h3>Thành công!</h3>
			<p><?= $msg ?></p>
			<button onclick="closePopup()">Đóng</button>
		</div>
	</div>
<?php endif; ?>

<section class="breadcrumb-area">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<a href="index.php">Trang chủ</a> <span>/</span> <strong>Hồ sơ của tôi</strong>
			</div>
		</div>
	</div>
</section>

<section id="profile-edit" class="clearfix">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="card-box">
					<h3 class="card-title">Thông Tin Cá Nhân</h3>
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
							<div class="col-md-4">
								<div class="profile-card text-center">
									<div class="avatar-wrapper">
										<?php if (!empty($user) && !empty($user->getAvatar_url())): ?>
											<img id="avatar_preview" src="assets/img/avatars/<?= htmlspecialchars($user->getAvatar_url()) ?>" alt="Avatar" class="img-thumbnail avatar-lg">
										<?php else: ?>
											<img id="avatar_preview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Ccircle cx='100' cy='100' r='100' fill='%23e9ecef'/%3E%3C/svg%3E" alt="Avatar" class="img-thumbnail avatar-lg">
										<?php endif; ?>
									</div>
									<input type="file" id="avatar_url" name="avatar_url" accept="image/*" style="display:none">
									<p class="text-muted">Nhấn vào ảnh để thay đổi</p>
									<div class="profile-meta">
										<p><strong><?= htmlspecialchars($user->getFull_name() ?? '') ?></strong></p>
									</div>
								</div>
							</div>

							<div class="col-md-8">
								<div class="form-row">
									<div class="form-group col-sm-12">
										<label for="user_name">Tên đăng nhập</label>
										<input type="text" class="form-control" id="user_name" value="<?= htmlspecialchars($user->getUser_name() ?? '') ?>" disabled>
										<small class="text-muted">Tên đăng nhập không thể thay đổi</small>
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-sm-6">
										<label for="full_name">Họ và tên <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($user->getFull_name() ?? '') ?>" required>
									</div>
									<div class="form-group col-sm-6">
										<label for="phone_number">Số điện thoại <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user->getPhone_number() ?? '') ?>" required>
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-sm-12">
										<label for="email">Email <span class="text-danger">*</span></label>
										<input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user->getEmail() ?? '') ?>" required pattern="[a-zA-Z0-9._%+\-]+@example\.com$" title="Email phải có đuôi @example.com">
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-sm-8">
										<label for="address">Địa chỉ <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user->getAddress() ?? '') ?>" required>
									</div>

									<div class="form-group col-sm-4">
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

								<div class="form-row mt-3">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Cập nhật</button>
										<a href="index.php?page=Food" class="btn btn-default"><i class="fa fa-times"></i> Quay lại</a>
									</div>
								</div>
							</div>
						</div>
					</form>
</section>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const avatarInput = document.getElementById('avatar_url');
		const avatarPreview = document.getElementById('avatar_preview');
		const avatarWrapper = document.querySelector('.avatar-wrapper');
		const emailInput = document.getElementById('email');
		const form = document.querySelector('form');

		// Avatar handling
		if (avatarInput && avatarWrapper) {
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
			avatarWrapper.addEventListener('click', function() {
				avatarInput.click();
			});
		}

		// Email validation for @example.com domain
		if (emailInput) {
			emailInput.addEventListener('blur', function() {
				const email = this.value.trim();
				const emailPattern = /^[a-zA-Z0-9._%+\-]+@example\.com$/;

				if (email === '') {
					this.setCustomValidity('Email không được để trống.');
					this.classList.add('is-invalid');
					this.classList.remove('is-valid');
				} else if (!emailPattern.test(email)) {
					this.setCustomValidity('Email phải có đuôi @example.com');
					this.classList.add('is-invalid');
					this.classList.remove('is-valid');
				} else {
					this.setCustomValidity('');
					this.classList.remove('is-invalid');
					this.classList.add('is-valid');
				}
			});

			emailInput.addEventListener('input', function() {
				if (this.classList.contains('is-invalid')) {
					const email = this.value.trim();
					const emailPattern = /^[a-zA-Z0-9._%+\-]+@example\.com$/;
					if (emailPattern.test(email)) {
						this.setCustomValidity('');
						this.classList.remove('is-invalid');
						this.classList.add('is-valid');
					}
				}
			});
		}

		// Form submit validation
		if (form) {
			form.addEventListener('submit', function(e) {
				const email = emailInput.value.trim();
				const emailPattern = /^[a-zA-Z0-9._%+\-]+@example\.com$/;

				if (!emailPattern.test(email)) {
					e.preventDefault();
					emailInput.setCustomValidity('Email phải có đuôi @example.com');
					emailInput.classList.add('is-invalid');
					emailInput.focus();
					alert('Email phải có đuôi @example.com (ví dụ: username@example.com)');
					return false;
				}
			});
		}

		function closePopup() {
			var popup = document.getElementById("cart-notification");
			if (popup) popup.style.display = "none";
		}
		setTimeout(closePopup, 3000);
	});
</script>
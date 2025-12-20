<div class="container-fluid py-3">
	<div class="d-flex align-items-center justify-content-between mb-3">
		<h3 class="mb-0">Phân quyền người dùng</h3>
		<a class="btn btn-secondary" href="index.php?page=UserAdmin">← Quay lại danh sách</a>
	</div>

	<?php if (!empty($errors)): ?>
		<div class="alert alert-danger">
			<?php foreach ($errors as $err): ?>
				<div><?= htmlspecialchars($err) ?></div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<form method="post" action="index.php?page=UserAdmin&action=UpdatePost">
		<input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id ?? ($user->getUser_id() ?? '')) ?>">

		<div class="row g-4">
			<!-- Cột trái: Thông tin người dùng -->
			<div class="col-lg-6">
				<div class="card h-100">
					<div class="card-header bg-light">
						<h5 class="mb-0"><i class="fa fa-user"></i> Thông tin người dùng</h5>
					</div>
					<div class="card-body">
						<div class="text-center mb-4">
							<?php
								$current_avatar = $user->getAvatar_url() ?? '';
								$avatar_path = !empty($current_avatar) ? '../assets/img/avatars/' . $current_avatar : 'https://via.placeholder.com/150x150?text=Avatar';
							?>
							<img src="<?= htmlspecialchars($avatar_path) ?>" alt="avatar" class="rounded-circle mb-2" style="width:150px;height:150px;object-fit:cover;border:3px solid #dee2e6;">
							<p class="text-muted small mb-0">Ảnh đại diện</p>
						</div>
						
						<div class="mb-3">
							<label class="form-label fw-bold text-secondary">Họ tên</label>
							<input class="form-control-plaintext border-bottom" type="text" value="<?= htmlspecialchars($user->getFull_name() ?? '') ?>" readonly>
						</div>
						<div class="mb-3">
							<label class="form-label fw-bold text-secondary">Số điện thoại</label>
							<input class="form-control-plaintext border-bottom" type="text" value="<?= htmlspecialchars($user->getPhone_number() ?? '') ?>" readonly>
						</div>
						<div class="mb-3">
							<label class="form-label fw-bold text-secondary">Địa chỉ</label>
							<input class="form-control-plaintext border-bottom" type="text" value="<?= htmlspecialchars($user->getAddress() ?? '') ?>" readonly>
						</div>
						<div class="mb-3">
							<label class="form-label fw-bold text-secondary">Tỉnh/Thành phố</label>
							<input class="form-control-plaintext border-bottom" type="text" value="<?= htmlspecialchars($user->getCity() ?? '') ?>" readonly>
						</div>
						<div class="mb-3">
							<label class="form-label fw-bold text-secondary">Trạng thái</label>
							<?php $is_active = (int)($user->getIs_active() ?? 1); ?>
							<div class="mt-2">
								<span class="badge <?= $is_active ? 'bg-success' : 'bg-secondary' ?> fs-6"><?= $is_active === 1 ? 'Hoạt động' : 'Khoá' ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Cột phải: Phân quyền -->
			<div class="col-lg-6">
				<div class="card h-100">
					<div class="card-header bg-primary text-white">
						<h5 class="mb-0"><i class="fa fa-shield"></i> Phân quyền</h5>
					</div>
					<div class="card-body">
						
						<div class="d-flex flex-column gap-3">
							<?php if (!empty($list_roles)): ?>
								<?php 
									$currentRoleId = !empty($current_role_ids) ? $current_role_ids[0] : null;
								?>
								<?php foreach ($list_roles as $role): ?>
									<?php $rid = $role->getRole_id(); ?>
									<div class="form-check p-3 border rounded" style="background-color: #f8f9fa;">
										<input class="form-check-input" type="radio" name="role" value="<?= htmlspecialchars($rid) ?>" id="role<?= htmlspecialchars($rid) ?>" <?= ($rid == $currentRoleId) ? 'checked' : '' ?> style="width:20px;height:20px;" required>
										<label class="form-check-label ms-2 fs-5" for="role<?= htmlspecialchars($rid) ?>">
											<?= htmlspecialchars($role->getRole_name()) ?>
										</label>
									</div>
								<?php endforeach; ?>
							<?php else: ?>
								<div class="alert alert-warning">Chưa có vai trò nào trong hệ thống.</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="card-footer bg-white">
						<div class="d-flex justify-content-end gap-2">
							<a class="btn btn-outline-secondary" href="index.php?page=UserAdmin"><i class="fa fa-times"></i> Huỷ</a>
							<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Cập nhật vai trò</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

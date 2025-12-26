<div class="container-fluid pt-4 px-4">
	<div class="bg-secondary rounded h-100 p-4">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<h6 class="mb-0 text-primary">Phân quyền người dùng</h6>
			<a href="index.php?page=UserAdmin" class="btn btn-outline-primary btn-sm"><i class="fa fa-arrow-left me-2"></i>Quay lại</a>
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

			<?php
			$currentRoleId = !empty($current_role_ids) ? $current_role_ids[0] : null;
			$currentRoleName = '';
			if (!empty($list_roles)) {
				foreach ($list_roles as $r) {
					if ($r->getRole_id() == $currentRoleId) {
						$currentRoleName = $r->getRole_name();
						break;
					}
				}
			}
			?>

			<div class="row">
				<div class="col-12">
					<div class="card mb-4 h-100">
						<div class="card-header bg-warning text-white">
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
								<label class="form-label fw-bold text-secondary">Email</label>
								<input class="form-control-plaintext border-bottom" type="text" value="<?= htmlspecialchars($user->getEmail() ?? '') ?>" readonly>
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

							<!-- Phân quyền: chuyển thành select dưới dòng Trạng thái -->
							<div class="mb-3">
								<label class="form-label fw-bold text-secondary">Phân quyền</label>
								<div class="form-floating">
									<select class="form-select" id="roleSelect" name="role" required>
										<?php if (!empty($list_roles)): ?>
											<?php foreach ($list_roles as $role): $rid = $role->getRole_id(); ?>
												<option value="<?= htmlspecialchars($rid) ?>" <?= ($rid == $currentRoleId) ? 'selected' : '' ?>><?= htmlspecialchars($role->getRole_name()) ?></option>
											<?php endforeach; ?>
										<?php else: ?>
											<option value="">-- Chưa có vai trò --</option>
										<?php endif; ?>
									</select>
									<label for="roleSelect">Chọn vai trò</label>
								</div>
							</div>
							<div class="card-footer bg-white">
								<p class="text-muted">Vai trò hiện tại</p>
								<?php if (!empty($currentRoleName)): ?>
									<span class="badge bg-info text-dark fs-6"><?= htmlspecialchars($currentRoleName) ?></span>
								<?php else: ?>
									<span class="text-muted">Chưa có vai trò</span>
								<?php endif; ?>
								<br>
								<div class="d-flex justify-content-end align-items-center gap-2">
									<a class="btn btn-outline-primary btn-sm px-3" href="index.php?page=UserAdmin"><i class="fa fa-arrow-left me-1"></i>Quay lại</a>
									<button class="btn btn-warning btn-sm px-3" type="submit"><i class="fa fa-save me-1"></i>Lưu</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
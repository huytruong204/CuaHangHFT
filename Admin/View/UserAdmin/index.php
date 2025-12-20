<div class="container-fluid py-3">
	<div class="d-flex align-items-center justify-content-between mb-3">
		<h3 class="mb-0">Quản lý người dùng</h3>
		<form class="d-flex align-items-center gap-2" method="get" action="index.php" style="min-width: 400px;">
			<input type="hidden" name="page" value="UserAdmin">
			<input class="form-control" type="text" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Tìm theo tên đăng nhập hoặc họ tên" style="flex: 1;">
			<button class="btn btn-primary" type="submit" style="white-space: nowrap;"><i class="fa fa-search"></i> Tìm</button>
		</form>
	</div>

	<?php if (!empty($msg = SessionManager::flash('success'))): ?>
		<div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
	<?php endif; ?>
	<?php if (!empty($msg = SessionManager::flash('error'))): ?>
		<div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
	<?php endif; ?>

	<div class="table-responsive">
		<table class="table table-striped table-hover align-middle">
			<thead>
				<tr>
					<th>ID</th>
					<th>Avatar</th>
					<th>Tài khoản</th>
					<th>Họ tên</th>
					<th>Điện thoại</th>
					<th>Vai trò</th>
					<th>Trạng thái</th>
					<th>Ngày tạo</th>
					<th class="text-end">Thao tác</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($list_users)): ?>
					<?php foreach ($list_users as $u): ?>
						<tr>
							<td><?= htmlspecialchars($u['user_id']) ?></td>
							<td>
						<?php $avt = !empty($u['avatar_url']) ? '../assets/img/avatars/' . $u['avatar_url'] : 'https://via.placeholder.com/40x40?text=+'; ?>
								<img src="<?= $avt ?>" alt="avatar" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
							</td>
							<td><?= htmlspecialchars($u['user_name'] ?? '') ?></td>
							<td><?= htmlspecialchars($u['full_name'] ?? '') ?></td>
							<td><?= htmlspecialchars($u['phone_number'] ?? '') ?></td>
							<td>
								<?php
									$roleBadges = '';
									$rolesArr = array_filter(array_map('trim', explode(',', $u['roles_list'] ?? '')));
									foreach ($rolesArr as $role) {
										$lower = strtolower($role);
										$class = 'bg-secondary';
										$icon = 'fa-user';
										
										if ($lower === 'admin') {
											$class = 'bg-danger';
											$icon = 'fa-user-shield';
										} elseif ($lower === 'customer') {
											$class = 'bg-success';
											$icon = 'fa-shopping-cart';
										} elseif ($lower === 'shipper') {
											$class = 'bg-warning text-dark';
											$icon = 'fa-truck';
										}
										
										$roleBadges .= '<span class="badge '.$class.' me-1 px-3 py-2" style="font-size: 0.875rem; font-weight: 500;"><i class="fa '.$icon.' me-1"></i>'.htmlspecialchars($role).'</span>';
									}
									echo $roleBadges ?: '<span class="text-muted fst-italic">Chưa phân quyền</span>';
								?>
							</td>
							<td>
								<?php $active = (int)($u['is_active'] ?? 0); ?>
								<span class="badge <?= $active ? 'bg-success' : 'bg-secondary' ?>"><?= $active ? 'Hoạt động' : 'Khoá' ?></span>
							</td>
							<td><?= htmlspecialchars($u['created_at'] ?? '') ?></td>
							<td class="text-end">
								<a href="index.php?page=UserAdmin&action=UpdateGet&user_id=<?= urlencode($u['user_id']) ?>" class="btn btn-sm btn-outline-primary">
									<i class="fa fa-pencil"></i> Sửa
								</a>
								<a href="index.php?page=UserAdmin&action=ToggleStatus&user_id=<?= urlencode($u['user_id']) ?>&status=<?= $active ?>" class="btn btn-sm btn-outline-warning ms-1">
									<i class="fa fa-toggle-on"></i> <?= $active ? 'Khoá' : 'Mở' ?>
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="9" class="text-center py-4">Không có dữ liệu người dùng.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<?php if (!empty($total_pages) && $total_pages > 1): ?>
		<nav>
			<ul class="pagination justify-content-center">
				<?php $p = (int)($current_page ?? 1); ?>
				<?php $kw = htmlspecialchars($_GET['keyword'] ?? ''); ?>
				<li class="page-item <?= $p <= 1 ? 'disabled' : '' ?>">
					<a class="page-link" href="index.php?page=UserAdmin&p=<?= max(1, $p-1) ?>&keyword=<?= $kw ?>">«</a>
				</li>
				<?php for ($i = 1; $i <= $total_pages; $i++): ?>
					<li class="page-item <?= $i == $p ? 'active' : '' ?>">
						<a class="page-link" href="index.php?page=UserAdmin&p=<?= $i ?>&keyword=<?= $kw ?>"><?= $i ?></a>
					</li>
				<?php endfor; ?>
				<li class="page-item <?= $p >= $total_pages ? 'disabled' : '' ?>">
					<a class="page-link" href="index.php?page=UserAdmin&p=<?= min($total_pages, $p+1) ?>&keyword=<?= $kw ?>">»</a>
				</li>
			</ul>
		</nav>
	<?php endif; ?>
</div>

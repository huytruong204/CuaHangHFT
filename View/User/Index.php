<section id="center" class="center_shop clearfix">
	<div class="container">
		<div class="row">
			<div class="center_shop_1 clearfix">
				<div class="col-sm-12">
					<h2 class="mgt head_1"><i class="fa fa-user"></i> Hồ Sơ Người Dùng</h2>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="profile" class="clearfix">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Thông Tin Cá Nhân</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-3 text-center">
								<div class="profile-avatar">
									<?php if (!empty($user) && !empty($user->getAvatar_url())): ?>
										<img src="assets/img/avatars/<?= htmlspecialchars($user->getAvatar_url()) ?>" 
											 alt="Avatar" class="img-thumbnail" style="max-width: 150px;">
									<?php else: ?>
										<i class="fa fa-user-circle" style="font-size: 120px; color: #ccc;"></i>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-sm-9">
								<?php if (empty($user)): ?>
									<div class="alert alert-warning">Không tìm thấy thông tin người dùng. Vui lòng đăng nhập.</div>
								<?php else: ?>
								<table class="table table-striped">
									<tbody>
										<tr>
											<th width="30%">Tên đăng nhập:</th>
											<td><?= htmlspecialchars($user->getUser_name()) ?></td>
										</tr>
										<tr>
											<th>Họ và tên:</th>
											<td><?= htmlspecialchars($user->getFull_name()) ?></td>
										</tr>
										<tr>
											<th>Số điện thoại:</th>
											<td><?= htmlspecialchars($user->getPhone_number()) ?></td>
										</tr>
										<tr>
											<th>Địa chỉ:</th>
											<td><?= htmlspecialchars($user->getAddress()) ?></td>
										</tr>
										<tr>
											<th>Tỉnh/Thành phố:</th>
											<td><?= htmlspecialchars($user->getCity()) ?></td>
										</tr>
										<tr>
											<th>Trạng thái:</th>
											<td>
												<?php if ($user->getIs_active() == 1): ?>
													<span class="label label-success">Đang hoạt động</span>
												<?php else: ?>
													<span class="label label-danger">Đã khóa</span>
												<?php endif; ?>
											</td>
										</tr>
										<tr>
											<th>Ngày tạo:</th>
											<td><?= date('d/m/Y H:i', strtotime($user->getCreated_at() ?? 'now')) ?></td>
										</tr>
									</tbody>
								</table>

								<div class="text-right" style="margin-top: 20px;">
									<a href="index.php?page=User&action=Edit" class="btn btn-primary">
										<i class="fa fa-edit"></i> Chỉnh sửa thông tin
									</a>
									<a href="index.php?page=Order" class="btn btn-info">
										<i class="fa fa-list"></i> Đơn hàng của tôi
									</a>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
.profile-avatar { margin-bottom: 15px; }
.panel-heading { background-color: #f5f5f5; border-bottom: 2px solid #e74c3c; }
.panel-title { font-weight: bold; font-size: 18px; }
</style>


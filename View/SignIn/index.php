<section class="signin-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="panel panel-default mx-auto auth-panel signin">
					<div class="text-center mb-2">
						<h2>Đăng nhập</h2> <br>
					</div>

					<?php if (!empty($error_message) || !empty($errors) || !empty($auth_error)): ?>
						<div class="alert alert-danger">
							<?php
							if (!empty($auth_error)) echo $auth_error;
							elseif (!empty($error_message)) echo $error_message;
							elseif (!empty($errors) && is_array($errors)) echo implode('<br>', $errors);
							?>
						</div>
					<?php endif; ?>

					<form action="index.php?page=SignIn&action=login" method="post" novalidate>
						<div class="form-group">
							<label for="user_name">Tài khoản</label>
							<input type="text" class="form-control" id="user_name" name="user_name" placeholder="Tên đăng nhập" required value="<?= htmlspecialchars($_POST['user_name'] ?? '') ?>">
						</div>

						<div class="form-group">
							<label for="password">Mật khẩu</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
						</div>

						<div class="form-group clearfix">
							<div class="pull-right"><a href="index.php?page=Forgot">Quên mật khẩu?</a></div>
						</div>

						<button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>

						<div class="text-center mt-3">
							<small>Bạn chưa có tài khoản? <a href="index.php?page=SignUp">Đăng ký</a></small>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
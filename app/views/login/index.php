	<?php require_once 'app/views/templates/headerPublic.php'; ?>

	<div class="container mt-5">
			<h2>Login</h2>

			<?php
			$locked = false;
			$remaining = 0;

			if (isset($_SESSION['lastFailed']) && isset($_SESSION['failedAuth']) && $_SESSION['failedAuth'] >= 3) {
					$elapsed = time() - $_SESSION['lastFailed'];
					if ($elapsed < 60) {
							$locked = true;
							$remaining = 60 - $elapsed;
					} else {
							$_SESSION['failedAuth'] = 0;
							unset($_SESSION['lastFailed']);
					}
			}
			?>

			<!-- Show success message after registration -->
			<?php if (!empty($_SESSION['message'])): ?>
					<div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
			<?php endif; ?>

			<!-- Show login error -->
			<?php if (!empty($_SESSION['error'])): ?>
					<div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
			<?php endif; ?>

			<form method="post" action="/login/verify" id="loginForm">
					<div class="mb-3">
							<label>Username</label>
							<input
									type="text"
									name="username"
									required
									class="form-control"
									value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
									<?= $locked ? 'readonly' : '' ?>
									id="username"
							>
					</div>

					<div class="mb-3">
							<label>Password</label>
							<input
									type="password"
									name="password"
									id="password"
									required
									class="form-control"
									<?= $locked ? 'disabled' : '' ?>
							>
					</div>

					<?php if ($locked): ?>
							<div class="alert alert-warning" id="lockoutBar">
									<span id="lockoutMessage">Too many failed attempts. Please wait <span id="countdown"><?= $remaining ?></span> seconds.</span>
							</div>
					<?php endif; ?>

					<button type="submit" class="btn btn-primary" id="loginBtn" <?= $locked ? 'disabled' : '' ?>>Login</button>
			</form>

			<!-- Create Account Button + Back to Welcome -->
			<div class="mt-3">
					<a href="/create" class="btn btn-success">Create an Account</a>
					<a href="/welcome" class="btn btn-dark ms-2">Back</a>
			</div>
	</div>

	<?php if ($locked): ?>
	<script>
			let seconds = <?= $remaining ?>;
			const countdownSpan = document.getElementById('countdown');
			const lockoutMessage = document.getElementById('lockoutMessage');
			const passwordField = document.getElementById('password');
			const loginBtn = document.getElementById('loginBtn');
			const usernameField = document.getElementById('username');

			const interval = setInterval(() => {
					seconds--;
					if (seconds > 0) {
							countdownSpan.textContent = seconds;
					} else {
							clearInterval(interval);
							passwordField.disabled = false;
							loginBtn.disabled = false;
							usernameField.readOnly = false;

							// Replace the countdown message
							lockoutMessage.textContent = "Please try logging in again.";
					}
			}, 1000);
	</script>
	<?php endif; ?>

	<?php require_once 'app/views/templates/footer.php'; ?>

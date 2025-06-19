<?php
require_once 'app/models/User.php';

class Login extends Controller {
		public function index() {
				$this->view('login/index');
		}

		public function verify() {
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$username = isset($_POST['username']) ? trim($_POST['username']) : '';
						$password = isset($_POST['password']) ? trim($_POST['password']) : '';

						if ($username && $password) {
								$userModel = new User();
								$userModel->authenticate($username, $password);
						} else {
								$_SESSION['error'] = "Please fill in both fields.";
								header("Location: /login");
								exit;
						}
				} else {
						header("Location: /login");
						exit;
				}
		}
}

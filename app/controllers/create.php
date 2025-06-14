<?php

class Create extends Controller {

    public function index() {
        $this->view('create/index');
    }

    public function register() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->model('User');
        $user->create($username, $password);
        $_SESSION['success'] = "Account created. Please login.";
        header('Location: /login');
    }
}

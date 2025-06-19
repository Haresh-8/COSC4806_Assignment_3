<?php

class Create extends Controller {
    public function index() {
        $this->view('create/index');
    }

    public function store() {
        $username = strtolower(trim($_POST['username']));
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if (strlen($password) < 6) {
            $_SESSION['error'] = "Password must be at least 6 characters long.";
            header("Location: /create");
            exit;
        }


        $db = db_connect();
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);

        $_SESSION['message'] = "Account created. Please login.";
        header("Location: /login");
        exit;
    }
}

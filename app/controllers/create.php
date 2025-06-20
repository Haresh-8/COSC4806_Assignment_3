<?php

class Create extends Controller {
    public function index() {
        $this->view('create/index');
    }

    public function store() {
        $username = strtolower(trim($_POST['username']));
        $passwordInput = trim($_POST['password']);

        // Validate password length
        if (strlen($passwordInput) < 6) {
            $_SESSION['error'] = "Password must be at least 6 characters long.";
            header("Location: /create");
            exit;
        }

        $db = db_connect();

        // Check if username already exists
        $checkStmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $checkStmt->execute([$username]);

        if ($checkStmt->fetchColumn() > 0) {
            $_SESSION['error'] = "Username already exists. Please choose another.";
            header("Location: /create");
            exit;
        }

        // Hash and insert user
        $password = password_hash($passwordInput, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);

        $_SESSION['message'] = "Account created successfully. Please login.";
        header("Location: /login");
        exit;
    }
}

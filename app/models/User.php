<?php

class User {

    public function authenticate($username, $password) {
        $db = db_connect();
        $username = strtolower($username);

        $statement = $db->prepare("SELECT * FROM users WHERE username = :name");
        $statement->bindValue(':name', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        $this->logAttempt($username, $db, 'attempt');

        if ($this->isLockedOut($username, $db)) {
            $_SESSION['error'] = "Too many failed attempts. Try again after 60 seconds.";
            header('Location: /login');
            exit;
        }

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['auth'] = 1;
            $_SESSION['username'] = ucwords($username);
            $this->logAttempt($username, $db, 'success');
            $_SESSION['failedAuth'] = 0;
            header('Location: /home');
            exit;
        } else {
            $_SESSION['failedAuth'] = ($_SESSION['failedAuth'] ?? 0) + 1;
            $this->logAttempt($username, $db, 'fail');
            $_SESSION['error'] = "Invalid credentials.";
            header('Location: /login');
            exit;
        }
    }

    private function logAttempt($username, $db, $status) {
        $statement = $db->prepare("INSERT INTO login_log (username, status, log_time) VALUES (:username, :status, NOW())");
        $statement->execute([
            ':username' => $username,
            ':status' => $status === 'success' ? 'success' : 'fail'
        ]);
    }

    private function isLockedOut($username, $db) {
        $statement = $db->prepare("
            SELECT COUNT(*) AS failures, MAX(log_time) AS last_fail
            FROM login_log 
            WHERE username = :username AND status = 'fail'
              AND log_time > (NOW() - INTERVAL 5 MINUTE)
        ");
        $statement->execute([':username' => $username]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result['failures'] >= 3) {
            $lastFail = strtotime($result['last_fail']);
            if (time() - $lastFail < 60) {
                return true;
            }
        }

        return false;
    }

    public function create($username, $password) {
        $db = db_connect();
        $username = strtolower($username);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $statement = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $statement->execute([
            ':username' => $username,
            ':password' => $hashedPassword
        ]);
    }
}

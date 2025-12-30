<?php

class AuthController {

    protected $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: /?page=product&action=list');
                exit;
            } else {
                $error = 'Email ou mot de passe incorrect';
            }
        }

        require __DIR__ . '/../Views/auth/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($this->userModel->findByEmail($email)) {
                $error = 'Email déjà utilisé';
            } elseif (strlen($password) < 6) {
                $error = 'Mot de passe trop court (min 6 caractères)';
            } else {
                $this->userModel->create($email, $password, $fullname);
                $_SESSION['user'] = $this->userModel->findByEmail($email);
                header('Location: /?page=product&action=list');
                exit;
            }
        }

        require __DIR__ . '/../Views/auth/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /?page=product&action=list');
        exit;
    }
}

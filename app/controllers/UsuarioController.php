<?php

class UsuarioController
{
    public function login()
    {
        require_once __DIR__ . '/../Handcrafted-Items-main/public/login.php';
    }

    public function authenticate()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: login.php');
            exit;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === '123456') {

            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;

            header('Location: index.php');
            exit;
        }

        $_SESSION['erro_login'] = 'Usuário ou senha inválidos.';
        header('Location: login.php');
        exit;
    }

    public function logout()
    {
        session_start();

        session_unset();
        session_destroy();

        header('Location: login.php');
        exit;
    }
}
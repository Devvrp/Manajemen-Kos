<?php

class Controller
{
    public function view($template, $data = [])
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        extract($data);
        $flashes = $this->takeFlashes();
        require_once __DIR__ . '/../Views/Layout/Header.php';
        require_once __DIR__ . '/../Views/' . $template . '.php';
        require_once __DIR__ . '/../Views/Layout/Footer.php';
    }
    public function redirect($url)
    {
        header("Location: " . $url);
        exit;
    }
    public function flash($type, $message)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['flashes'][] = ['type' => $type, 'message' => $message];
    }
    public function takeFlashes()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $flashes = $_SESSION['flashes'] ?? [];
        unset($_SESSION['flashes']);
        return $flashes;
    }
}
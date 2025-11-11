<?php

class Auth
{
    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function login($user)
    {
        self::startSession();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_nama'] = $user['nama_lengkap'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_branch_id'] = $user['branch_id'];
    }
    public static function logout()
    {
        self::startSession();
        $_SESSION = [];
        session_destroy();
    }
    public static function isLoggedIn()
    {
        self::startSession();
        return isset($_SESSION['user_id']);
    }
    public static function userId()
    {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }
    public static function userName()
    {
        self::startSession();
        return $_SESSION['user_nama'] ?? 'Guest';
    }

    public static function userRole()
    {
        self::startSession();
        return $_SESSION['user_role'] ?? null;
    }
    public static function userBranchId()
    {
        self::startSession();
        return $_SESSION['user_branch_id'] ?? null;
    }
    public static function checkRole($role)
    {
        self::startSession();
        if (!self::isLoggedIn()) {
            return false;
        }
        if (is_array($role)) {
            return in_array(self::userRole(), $role);
        }
        return self::userRole() === $role;
    }
    public static function protect()
    {
        if (!self::isLoggedIn()) {
            header("Location: index.php?c=auth&a=login");
            exit;
        }
    }
    public static function protectRole($role)
    {
        self::protect();
        if (!self::checkRole($role)) {
            http_response_code(403);
            echo "403 Forbidden - Anda tidak memiliki hak akses.";
            exit;
        }
    }
}
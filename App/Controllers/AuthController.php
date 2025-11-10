<?php

class AuthController extends Controller
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function login()
    {
        $this->view('auth/login', ['title' => 'Login', 'errors' => [], 'old' => []]);
    }
    public function register()
    {
        $this->view('auth/register', ['title' => 'Register', 'errors' => [], 'old' => []]);
    }
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=auth&a=login');
        }
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $this->flash('error', 'Email atau password salah.');
            $this->redirect('index.php?c=auth&a=login');
        }
        if ($user['status'] === 'banned') {
            $this->flash('error', 'Akun Anda telah di-banned.');
            $this->redirect('index.php?c=auth&a=login');
        }
        Auth::login($user);
        Log::record($user['user_id'], 'Berhasil login ke sistem.');
        $this->flash('success', 'Login berhasil, selamat datang ' . htmlspecialchars($user['nama_lengkap']));
        $this->redirect('index.php?c=home&a=index');
    }
    public function storeUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=auth&a=register');
        }
        $validator = new Validator();
        $rules = [
            'nama_lengkap' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed:confirm_password'
        ];
        if (!$validator->validate($_POST, $rules)) {
            $data = [
                'title' => 'Register',
                'errors' => $validator->getErrors(),
                'old' => $_POST
            ];
            $this->view('auth/register', $data);
            return;
        }
        $this->userModel->create($_POST);
        $this->flash('success', 'Registrasi berhasil. Silakan login.');
        $this->redirect('index.php?c=auth&a=login');
    }
    public function logout()
    {
        Auth::logout();
        $this->flash('success', 'Anda telah berhasil logout.');
        $this->redirect('index.php?c=auth&a=login');
    }
}
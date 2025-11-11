<?php

class UserController extends Controller
{
    private $userModel;
    private $branchModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole('superadmin');
        $this->userModel = new User();
        $this->branchModel = new Branch();
    }
    public function index()
    {
        $users = $this->userModel->getAll();
        $data = [
            'title' => 'Manajemen User',
            'users' => $users
        ];
        $this->view('User/index', $data);
    }
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $user = $this->userModel->findById($id);
        if (!$user) {
            $this->flash('error', 'User tidak ditemukan.');
            $this->redirect('index.php?c=user&a=index');
        }
        $data = [
            'title' => 'Edit User: ' . htmlspecialchars($user['nama_lengkap']),
            'user' => $user,
            'branches' => $this->branchModel->getAll(),
            'errors' => [],
            'old' => $user
        ];
        $this->view('User/edit', $data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=user&a=index');
        }
        $id = $_POST['id'] ?? 0;
        $validator = new Validator();
        $rules = [
            'nama_lengkap' => 'required',
            'email' => 'required|email'
        ];
        if (!$validator->validate($_POST, $rules)) {
            $user = $this->userModel->findById($id);
            $data = [
                'title' => 'Edit User: ' . htmlspecialchars($user['nama_lengkap']),
                'user' => $user,
                'branches' => $this->branchModel->getAll(),
                'errors' => $validator->getErrors(),
                'old' => $_POST
            ];
            $this->view('User/edit', $data);
            return;
        }
        $this->userModel->update($id, $_POST);
        Log::record(Auth::userId(), "Memperbarui user #$id: " . $_POST['email']);
        $this->flash('success', 'Data user berhasil diperbarui.');
        $this->redirect('index.php?c=user&a=index');
    }
    public function destroy()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=user&a=index');
        }
        $id = $_POST['id'] ?? 0;
        if ($id == Auth::userId()) {
            $this->flash('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
            $this->redirect('index.php?c=user&a=index');
        }
        $this->userModel->delete($id);
        Log::record(Auth::userId(), "Melakukan soft delete pada user #$id");
        $this->flash('success', 'User berhasil dihapus (soft delete).');
        $this->redirect('index.php?c=user&a=index');
    }
    public function recycleBin()
    {
        $users = $this->userModel->getAllDeleted();
        $data = [
            'title' => 'Recycle Bin - User',
            'users' => $users
        ];
        $this->view('User/recycle', $data);
    }
    public function restore()
    {
        $id = $_GET['id'] ?? 0;
        $this->userModel->restore($id);
        Log::record(Auth::userId(), "Memulihkan user #$id dari recycle bin");
        $this->flash('success', 'User berhasil dipulihkan.');
        $this->redirect('index.php?c=user&a=recycleBin');
    }
    public function forceDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=user&a=recycleBin');
        }
        $id = $_POST['id'] ?? 0;
        $this->userModel->forceDelete($id);
        Log::record(Auth::userId(), "Menghapus permanen user #$id");
        $this->flash('success', 'User berhasil dihapus permanen.');
        $this->redirect('index.php?c=user&a=recycleBin');
    }
}
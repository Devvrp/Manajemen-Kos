<?php

class BranchController extends Controller
{
    private $branchModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole('superadmin');
        $this->branchModel = new Branch();
    }
    public function index()
    {
        $branches = $this->branchModel->getAll();
        $data = [
            'title' => 'Manajemen Cabang Kos',
            'branches' => $branches
        ];
        $this->view('Branch/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Tambah Cabang Baru',
            'errors' => [],
            'old' => []
        ];
        $this->view('Branch/create', $data);
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=branch&a=index');
        }
        $validator = new Validator();
        $rules = ['nama_cabang' => 'required'];
        if (!$validator->validate($_POST, $rules)) {
            $data = [
                'title' => 'Tambah Cabang Baru',
                'errors' => $validator->getErrors(),
                'old' => $_POST
            ];
            $this->view('Branch/create', $data);
            return;
        }
        $this->branchModel->create($_POST);
        Log::record(Auth::userId(), 'Membuat cabang baru: ' . $_POST['nama_cabang']);
        $this->flash('success', 'Cabang baru berhasil ditambahkan.');
        $this->redirect('index.php?c=branch&a=index');
    }
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $branch = $this->branchModel->findById($id);
        if (!$branch) {
            $this->flash('error', 'Cabang tidak ditemukan.');
            $this->redirect('index.php?c=branch&a=index');
        }
        $data = [
            'title' => 'Edit Cabang',
            'branch' => $branch,
            'errors' => [],
            'old' => $branch
        ];
        $this->view('Branch/edit', $data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=branch&a=index');
        }
        $id = $_POST['id'] ?? 0;
        $validator = new Validator();
        $rules = ['nama_cabang' => 'required'];
        if (!$validator->validate($_POST, $rules)) {
            $data = [
                'title' => 'Edit Cabang',
                'errors' => $validator->getErrors(),
                'old' => $_POST,
                'branch' => ['branch_id' => $id]
            ];
            $this->view('Branch/edit', $data);
            return;
        }
        $this->branchModel->update($id, $_POST);
        Log::record(Auth::userId(), 'Memperbarui cabang #' . $id);
        $this->flash('success', 'Data cabang berhasil diperbarui.');
        $this->redirect('index.php?c=branch&a=index');
    }
    public function destroy()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=branch&a=index');
        }
        $id = $_POST['id'] ?? 0;
        $this->branchModel->delete($id);
        Log::record(Auth::userId(), 'Menghapus cabang #' . $id . ' (Soft Delete)');
        $this->flash('success', 'Data cabang berhasil dipindahkan ke Recycle Bin.');
        $this->redirect('index.php?c=branch&a=index');
    }
    public function recycleBin()
    {
        $branches = $this->branchModel->getAllDeleted();
        $data = [
            'title' => 'Recycle Bin - Cabang',
            'branches' => $branches
        ];
        $this->view('Branch/recycle', $data);
    }
    public function restore()
    {
        $id = $_GET['id'] ?? 0;
        $this->branchModel->restore($id);
        Log::record(Auth::userId(), "Memulihkan cabang #$id");
        $this->flash('success', 'Cabang berhasil dipulihkan.');
        $this->redirect('index.php?c=branch&a=recycleBin');
    }
    public function forceDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=branch&a=recycleBin');
        }
        $id = $_POST['id'] ?? 0;
        $this->branchModel->forceDelete($id);
        Log::record(Auth::userId(), "Menghapus permanen cabang #$id");
        $this->flash('success', 'Cabang berhasil dihapus permanen.');
        $this->redirect('index.php?c=branch&a=recycleBin');
    }
}
<?php

class RoomController extends Controller
{
    private $roomModel;
    private $branchModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole(['admin', 'superadmin']);
        $this->roomModel = new Room();
        $this->branchModel = new Branch();
    }
    public function index()
    {
        $filters = [
            'branch_id' => $_GET['branch_id'] ?? null,
            'harga_max' => $_GET['harga_max'] ?? null,
            'fasilitas' => $_GET['fasilitas'] ?? null
        ];
        if (Auth::checkRole('admin')) {
            $filters['branch_id'] = Auth::userBranchId();
        }
        $rooms = $this->roomModel->getAll($filters);
        $branches = (Auth::checkRole('superadmin')) ? $this->branchModel->getAll() : [];
        $data = [
            'title' => 'Manajemen Kamar',
            'rooms' => $rooms,
            'branches' => $branches,
            'filters' => $filters
        ];
        $this->view('Rooms/index', $data);
    }
    public function create()
    {
        $branches = (Auth::checkRole('superadmin')) ? $this->branchModel->getAll() : [];
        $data = [
            'title' => 'Tambah Kamar Baru',
            'branches' => $branches,
            'errors' => [],
            'old' => []
        ];
        $this->view('Rooms/create', $data);
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=room&a=index');
        }
        $data = $_POST;
        if (Auth::checkRole('admin')) {
            $data['branch_id'] = Auth::userBranchId();
        }
        $validator = new Validator();
        $rules = [
            'nomor_kamar' => 'required',
            'harga_bulanan' => 'required'
        ];
        if(Auth::checkRole('superadmin')) {
            $rules['branch_id'] = 'required';
        }
        if (!$validator->validate($data, $rules)) {
            $branches = (Auth::checkRole('superadmin')) ? $this->branchModel->getAll() : [];
            $viewData = [
                'title' => 'Tambah Kamar Baru',
                'branches' => $branches,
                'errors' => $validator->getErrors(),
                'old' => $_POST
            ];
            $this->view('Rooms/create', $viewData);
            return;
        }
        $this->roomModel->create($data);
        Log::record(Auth::userId(), 'Membuat kamar baru: ' . $data['nomor_kamar']);
        $this->flash('success', 'Kamar baru berhasil ditambahkan.');
        $this->redirect('index.php?c=room&a=index');
    }
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $room = $this->roomModel->findById($id);
        if (!$room) {
            $this->flash('error', 'Kamar tidak ditemukan.');
            $this->redirect('index.php?c=room&a=index');
        }
        if (Auth::checkRole('admin') && $room['branch_id'] != Auth::userBranchId()) {
            $this->flash('error', 'Anda tidak punya akses ke kamar ini.');
            $this->redirect('index.php?c=room&a=index');
        }
        $branches = (Auth::checkRole('superadmin')) ? $this->branchModel->getAll() : [];
        $data = [
            'title' => 'Edit Kamar: ' . htmlspecialchars($room['nomor_kamar']),
            'room' => $room,
            'branches' => $branches,
            'errors' => [],
            'old' => $room
        ];
        $this->view('Rooms/edit', $data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=room&a=index');
        }
        $id = $_POST['id'] ?? 0;
        $data = $_POST;
        if (Auth::checkRole('admin')) {
            $room = $this->roomModel->findById($id);
            if ($room['branch_id'] != Auth::userBranchId()) {
                $this->flash('error', 'Aksi tidak diizinkan.');
                $this->redirect('index.php?c=room&a=index');
            }
            $data['branch_id'] = Auth::userBranchId();
        }
        $validator = new Validator();
        $rules = [
            'nomor_kamar' => 'required',
            'harga_bulanan' => 'required'
        ];
        if(Auth::checkRole('superadmin')) {
            $rules['branch_id'] = 'required';
        }
        if (!$validator->validate($data, $rules)) {
            $branches = (Auth::checkRole('superadmin')) ? $this->branchModel->getAll() : [];
            $data['title'] = 'Edit Kamar: ' . htmlspecialchars($data['nomor_kamar']);
            $data['errors'] = $validator->getErrors();
            $data['old'] = $_POST;
            $data['room'] = $_POST;
            $data['room']['room_id'] = $id;
            $data['branches'] = $branches;
            $this->view('Rooms/edit', $data);
            return;
        }
        $this->roomModel->update($id, $data);
        Log::record(Auth::userId(), "Memperbarui kamar #$id: " . $data['nomor_kamar']);
        $this->flash('success', 'Data kamar berhasil diperbarui.');
        $this->redirect('index.php?c=room&a=index');
    }
    public function destroy()
    {
        Auth::protectRole('superadmin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=room&a=index');
        }
        $id = $_POST['id'] ?? 0;
        $this->roomModel->delete($id);
        Log::record(Auth::userId(), "Menghapus kamar #$id");
        $this->flash('success', 'Data kamar berhasil dihapus.');
        $this->redirect('index.php?c=room&a=index');
    }
}
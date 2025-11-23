<?php

class RoomTypeController extends Controller
{
    private $roomTypeModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole('superadmin'); // Hanya Superadmin
        $this->roomTypeModel = new RoomType();
    }
    public function index()
    {
        $data = [
            'title' => 'Master Tipe Kamar',
            'types' => $this->roomTypeModel->getAll()
        ];
        $this->view('RoomTypes/index', $data);
    }
    public function create()
    {
        $this->view('RoomTypes/create', ['title' => 'Tambah Tipe Kamar', 'errors' => [], 'old' => []]);
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('index.php?c=roomType&a=index');
        $validator = new Validator();
        if (!$validator->validate($_POST, ['nama_tipe' => 'required', 'harga_default' => 'required'])) {
            $this->view('RoomTypes/create', ['title' => 'Tambah Tipe', 'errors' => $validator->getErrors(), 'old' => $_POST]);
            return;
        }
        $this->roomTypeModel->create($_POST);
        $this->flash('success', 'Tipe kamar baru berhasil dibuat.');
        $this->redirect('index.php?c=roomType&a=index');
    }
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $type = $this->roomTypeModel->findById($id);
        if(!$type) $this->redirect('index.php?c=roomType&a=index');
        $this->view('RoomTypes/edit', ['title' => 'Edit Tipe Kamar', 'type' => $type, 'errors' => [], 'old' => $type]);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('index.php?c=roomType&a=index');
        $id = $_POST['id'];
        $this->roomTypeModel->update($id, $_POST);
        $this->flash('success', 'Tipe kamar berhasil diperbarui.');
        $this->redirect('index.php?c=roomType&a=index');
    }
    public function destroy()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('index.php?c=roomType&a=index');
        $this->roomTypeModel->delete($_POST['id']);
        $this->flash('success', 'Tipe kamar dihapus.');
        $this->redirect('index.php?c=roomType&a=index');
    }
}
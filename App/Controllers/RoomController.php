<?php

class RoomController extends Controller
{
    private $roomModel;
    public function __construct()
    {
        Auth::protect();
        $this->roomModel = new Room();
    }
    public function index()
    {
        Auth::protectRole(['admin', 'superadmin']);
        $rooms = $this->roomModel->getAll();
        $data = [
            'title' => 'Manajemen Kamar',
            'rooms' => $rooms
        ];
        $this->view('Rooms/index', $data);
    }
    public function create()
    {
        Auth::protectRole(['admin', 'superadmin']);
        $data = [
            'title' => 'Tambah Kamar Baru'
        ];
        $this->view('Rooms/create', $data);
    }
    public function store()
    {
        Auth::protectRole(['admin', 'superadmin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->roomModel->create($_POST);
            Log::record(Auth::userId(), 'Membuat kamar baru: ' . $_POST['nomor_kamar']);
            $this->flash('success', 'Kamar baru berhasil ditambahkan.');
            $this->redirect('index.php?c=room&a=index');
        }
    }
    public function edit()
    {
        Auth::protectRole(['admin', 'superadmin']);
        $id = $_GET['id'] ?? 0;
        $room = $this->roomModel->findById($id);
        if (!$room) {
            $this->flash('error', 'Kamar tidak ditemukan.');
            $this->redirect('index.php?c=room&a=index');
        }
        $data = [
            'title' => 'Edit Kamar: ' . htmlspecialchars($room['nomor_kamar']),
            'room' => $room
        ];
        $this->view('Rooms/edit', $data);
    }
    public function update()
    {
        Auth::protectRole(['admin', 'superadmin']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $this->roomModel->update($id, $_POST);
            Log::record(Auth::userId(), "Memperbarui kamar #$id: " . $_POST['nomor_kamar']);
            $this->flash('success', 'Data kamar berhasil diperbarui.');
            $this->redirect('index.php?c=room&a=index');
        }
    }
    public function destroy()
    {
        Auth::protectRole('superadmin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $this->roomModel->delete($id);
            Log::record(Auth::userId(), "Menghapus kamar #$id");
            $this->flash('success', 'Data kamar berhasil dihapus.');
            $this->redirect('index.php?c=room&a=index');
        }
    }
}
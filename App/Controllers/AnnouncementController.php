<?php

class AnnouncementController extends Controller
{
    private $announcementModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole(['admin', 'superadmin']);
        $this->announcementModel = new Announcement();
    }
    public function index()
    {
        $announcements = $this->announcementModel->getAll();
        $data = [
            'title' => 'Manajemen Pengumuman',
            'announcements' => $announcements
        ];
        $this->view('announcements/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Buat Pengumuman Baru'
        ];
        $this->view('announcements/create', $data);
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=announcement&a=index');
        }
        $data = [
            'user_id' => Auth::userId(),
            'judul' => $_POST['judul'] ?? '',
            'isi_pengumuman' => $_POST['isi_pengumuman'] ?? ''
        ];
        if (empty($data['judul']) || empty($data['isi_pengumuman'])) {
            $this->flash('error', 'Judul dan Isi Pengumuman wajib diisi.');
            $this->redirect('index.php?c=announcement&a=create');
        }
        $this->announcementModel->create($data);
        $this->flash('success', 'Pengumuman berhasil dipublikasikan.');
        $this->redirect('index.php?c=announcement&a=index');
    }
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $announcement = $this->announcementModel->findById($id);
        if (!$announcement) {
            $this->flash('error', 'Pengumuman tidak ditemukan.');
            $this->redirect('index.php?c=announcement&a=index');
        }
        $data = [
            'title' => 'Edit Pengumuman',
            'announcement' => $announcement
        ];
        $this->view('announcements/edit', $data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=announcement&a=index');
        }
        $id = $_POST['id'] ?? 0;
        $data = [
            'judul' => $_POST['judul'] ?? '',
            'isi_pengumuman' => $_POST['isi_pengumuman'] ?? ''
        ];
        if (empty($data['judul']) || empty($data['isi_pengumuman'])) {
            $this->flash('error', 'Judul dan Isi Pengumuman wajib diisi.');
            $this->redirect('index.php?c=announcement&a=edit&id=' . $id);
        }
        $this->announcementModel->update($id, $data);
        $this->flash('success', 'Pengumuman berhasil diperbarui.');
        $this->redirect('index.php?c=announcement&a=index');
    }
    public function destroy()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=announcement&a=index');
        }
        $id = $_POST['id'] ?? 0;
        $this->announcementModel->delete($id);
        $this->flash('success', 'Pengumuman berhasil dihapus.');
        $this->redirect('index.php?c=announcement&a=index');
    }
}
<?php

class AnnouncementController extends Controller
{
    private $announcementModel;
    private $branchModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole(['admin', 'superadmin']);
        $this->announcementModel = new Announcement();
        $this->branchModel = new Branch();
    }
    public function index()
    {
        $branch_id = (Auth::checkRole('admin')) ? Auth::userBranchId() : null;
        $announcements = $this->announcementModel->getAll($branch_id);
        $data = [
            'title' => 'Manajemen Pengumuman',
            'announcements' => $announcements
        ];
        $this->view('Announcements/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Buat Pengumuman Baru',
            'branches' => $this->branchModel->getAll(),
            'errors' => [],
            'old' => []
        ];
        $this->view('Announcements/create', $data);
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=announcement&a=index');
        }
        $data = [
            'user_id' => Auth::userId(),
            'branch_id' => $_POST['branch_id'] ?? null,
            'judul' => $_POST['judul'] ?? '',
            'isi_pengumuman' => $_POST['isi_pengumuman'] ?? ''
        ];
        if (empty($data['judul']) || empty($data['isi_pengumuman'])) {
            $viewData = [
                'title' => 'Buat Pengumuman Baru',
                'branches' => $this->branchModel->getAll(),
                'errors' => ['judul' => 'Judul dan isi wajib diisi', 'isi_pengumuman' => 'Wajib diisi'],
                'old' => $_POST
            ];
            $this->view('Announcements/create', $viewData);
            return;
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
            'announcement' => $announcement,
            'branches' => $this->branchModel->getAll(),
            'errors' => [],
            'old' => $announcement
        ];
        $this->view('Announcements/edit', $data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=announcement&a=index');
        }
        $id = $_POST['id'] ?? 0;
        $data = [
            'judul' => $_POST['judul'] ?? '',
            'isi_pengumuman' => $_POST['isi_pengumuman'] ?? '',
            'branch_id' => $_POST['branch_id'] ?? null
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
        Log::record(Auth::userId(), "Menghapus pengumuman #$id (Soft Delete)");
        $this->flash('success', 'Pengumuman berhasil dipindahkan ke Recycle Bin.');
        $this->redirect('index.php?c=announcement&a=index');
    }
    public function recycleBin()
    {
        $announcements = $this->announcementModel->getAllDeleted();
        $data = [
            'title' => 'Recycle Bin - Pengumuman',
            'announcements' => $announcements
        ];
        $this->view('Announcements/recycle', $data);
    }
    public function restore()
    {
        $id = $_GET['id'] ?? 0;
        $this->announcementModel->restore($id);
        Log::record(Auth::userId(), "Memulihkan pengumuman #$id");
        $this->flash('success', 'Pengumuman berhasil dipulihkan.');
        $this->redirect('index.php?c=announcement&a=recycleBin');
    }
    public function forceDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=announcement&a=recycleBin');
        }
        $id = $_POST['id'] ?? 0;
        $this->announcementModel->forceDelete($id);
        Log::record(Auth::userId(), "Menghapus permanen pengumuman #$id");
        $this->flash('success', 'Pengumuman berhasil dihapus permanen.');
        $this->redirect('index.php?c=announcement&a=recycleBin');
    }
}
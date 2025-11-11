<?php

class MaintenanceController extends Controller
{
    private $maintenanceModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole('penghuni');
        $this->maintenanceModel = new Maintenance();
    }
    public function index()
    {
        $userId = Auth::userId();
        $reports = $this->maintenanceModel->getByUserId($userId);
        $data = [
            'title' => 'Daftar Laporan Kerusakan Saya',
            'reports' => $reports
        ];
        $this->view('Maintenance/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Buat Laporan Kerusakan Baru',
            'errors' => [],
            'old' => []
        ];
        $this->view('Maintenance/create', $data);
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=maintenance&a=create');
        }
        $userId = Auth::userId();
        $contract = $this->maintenanceModel->getActiveContract($userId);
        if (!$contract) {
            $this->flash('error', 'Anda tidak memiliki kontrak kamar aktif.');
            $this->redirect('index.php?c=maintenance&a=index');
        }
        $data = [
            'user_id' => $userId,
            'room_id' => $contract['room_id'],
            'judul_laporan' => $_POST['judul_laporan'] ?? '',
            'deskripsi_kerusakan' => $_POST['deskripsi_kerusakan'] ?? ''
        ];
        $validator = new Validator();
        $rules = ['judul_laporan' => 'required'];
        if (!$validator->validate($data, $rules)) {
            $viewData = [
                'title' => 'Buat Laporan Kerusakan Baru',
                'errors' => $validator->getErrors(),
                'old' => $_POST
            ];
            $this->view('Maintenance/create', $viewData);
            return;
        }
        $this->maintenanceModel->create($data);
        $this->flash('success', 'Laporan kerusakan berhasil dikirim.');
        $this->redirect('index.php?c=maintenance&a=index');
    }
}
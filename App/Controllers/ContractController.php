<?php

class ContractController extends Controller
{
    private $contractModel;
    private $userModel;
    private $roomModel;
    private $branchModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole(['admin', 'superadmin']);
        $this->contractModel = new Contract();
        $this->userModel = new User();
        $this->roomModel = new Room();
        $this->branchModel = new Branch();
    }
    public function index()
    {
        $branch_id = (Auth::checkRole('admin')) ? Auth::userBranchId() : null;
        $contracts = $this->contractModel->getAllActiveContracts($branch_id);
        $data = [
            'title' => 'Manajemen Kontrak Aktif',
            'contracts' => $contracts
        ];
        $this->view('Contracts/index', $data);
    }
    public function create()
    {
        $branch_id = (Auth::checkRole('admin')) ? Auth::userBranchId() : null;
        if ($branch_id) {
            $rooms = $this->roomModel->getAvailableRooms($branch_id);
        } else {
            $rooms = $this->roomModel->getAll(['status' => 'tersedia']); 
        }
        $tenants = $this->userModel->getAvailableTenants();
        $branches = (Auth::checkRole('superadmin')) ? $this->branchModel->getAll() : [];
        $data = [
            'title' => 'Buat Kontrak Baru',
            'tenants' => $tenants,
            'rooms' => $rooms,
            'branches' => $branches,
            'errors' => [],
            'old' => []
        ];
        $this->view('Contracts/create', $data);
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=contract&a=index');
        }
        $data = [
            'user_id' => $_POST['user_id'] ?? 0,
            'room_id' => $_POST['room_id'] ?? 0,
            'tanggal_masuk' => $_POST['tanggal_masuk'] ?? ''
        ];
        if (empty($data['user_id']) || empty($data['room_id']) || empty($data['tanggal_masuk'])) {
            $this->flash('error', 'Semua field wajib diisi.');
            $this->redirect('index.php?c=contract&a=create');
        }   
        if ($this->contractModel->create($data)) {
            Log::record(Auth::userId(), "Membuat kontrak baru untuk user #{$data['user_id']} di kamar #{$data['room_id']}");
            $this->flash('success', 'Kontrak baru berhasil dibuat.');
        } else {
            $this->flash('error', 'Gagal membuat kontrak (transaksi dibatalkan).');
        }
        $this->redirect('index.php?c=contract&a=index');
    }
    public function end()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=contract&a=index');
        }
        $id = $_POST['contract_id'] ?? 0;
        if ($this->contractModel->endContract($id)) {
            Log::record(Auth::userId(), "Menyelesaikan kontrak #$id");
            $this->flash('success', 'Kontrak telah diselesaikan. Kamar kembali tersedia.');
        } else {
            $this->flash('error', 'Gagal menyelesaikan kontrak.');
        }
        $this->redirect('index.php?c=contract&a=index');
    }
}
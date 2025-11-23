<?php

class HomeController extends Controller
{
    public function index()
    {
        $data = [];
        $title = 'Selamat Datang di Kosan Kami!';
        if (Auth::isLoggedIn()) {
            $title = 'Dashboard ' . ucfirst(Auth::userRole());
            if (Auth::checkRole('penghuni')) {
                $announcementModel = new Announcement();
                $contractModel = new Contract();
                $contract = $contractModel->getActiveContractByUserId(Auth::userId());
                $branch_id = $contract['branch_id'] ?? null;
                $data['announcements'] = $announcementModel->getAll($branch_id, 5);
                $data['contract'] = $contract;
            } else {
                $branchModel = new Branch();
                $roomModel = new Room();
                $invoiceModel = new Invoice();
                $maintenanceModel = new Maintenance();
                $branch_id = Auth::checkRole('admin') ? Auth::userBranchId() : ($_GET['branch_id'] ?? null);
                $selected_branch_name = 'Semua Cabang';
                if (Auth::checkRole('admin')) {
                    $selected_branch_name = 'Cabang Anda';
                }
                if (Auth::checkRole('superadmin')) {
                    $data['branches'] = $branchModel->getAll();
                    if ($branch_id) {
                        $branch = $branchModel->findById($branch_id);
                        if ($branch) {
                            $selected_branch_name = $branch['nama_cabang'];
                        }
                    }
                }
                $allRooms = $roomModel->getAll(['branch_id' => $branch_id]);
                $pendingInvoices = $invoiceModel->getAllPendingVerification($branch_id);
                $reports = $maintenanceModel->getAll($branch_id);
                $stats = [
                    'total_kamar' => count($allRooms),
                    'tersedia' => 0,
                    'terisi' => 0,
                    'perbaikan' => 0,
                    'tagihan_pending' => count($pendingInvoices),
                    'laporan_baru' => 0
                ];
                foreach ($allRooms as $room) {
                    if ($room['status'] == 'tersedia') $stats['tersedia']++;
                    elseif ($room['status'] == 'terisi') $stats['terisi']++;
                    elseif ($room['status'] == 'perbaikan') $stats['perbaikan']++;
                }
                foreach ($reports as $report) {
                    if ($report['status_laporan'] == 'dilaporkan') {
                        $stats['laporan_baru']++;
                    }
                }
                $data['stats'] = $stats;
                $data['selected_branch_name'] = $selected_branch_name;
                $data['selected_branch_id'] = $branch_id;
            }
        }
        $data['title'] = $title;
        $this->view('Home/index', $data);
    }
}
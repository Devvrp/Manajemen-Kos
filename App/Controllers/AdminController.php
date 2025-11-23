<?php

class AdminController extends Controller
{
    private $maintenanceModel;
    private $invoiceModel;
    private $feedbackModel;
    private $logModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole(['admin', 'superadmin']);
        $this->maintenanceModel = new Maintenance();
        $this->invoiceModel = new Invoice();
        $this->feedbackModel = new Feedback();
        $this->logModel = new ActivityLog();
    }
    public function reports()
    {
        $branch_id = (Auth::checkRole('admin')) ? Auth::userBranchId() : null;
        $reports = $this->maintenanceModel->getAll($branch_id);
        $data = [
            'title' => 'Kelola Laporan Kerusakan',
            'reports' => $reports
        ];
        $this->view('Admin/reports', $data);
    }
    public function updateReportStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=admin&a=reports');
        }
        $id = $_POST['request_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        $allowedStatus = ['dilaporkan', 'dikerjakan', 'selesai'];
        if ($id > 0 && in_array($status, $allowedStatus)) {
            $this->maintenanceModel->updateStatus($id, $status);
            Log::record(Auth::userId(), "Mengubah status laporan #$id menjadi '$status'");
            $this->flash('success', 'Status laporan berhasil diperbarui.');
        } else {
            $this->flash('error', 'Gagal memperbarui status.');
        }
        $this->redirect('index.php?c=admin&a=reports');
    }
    public function destroyReport()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=admin&a=reports');
        }
        $id = $_POST['request_id'] ?? 0;
        if ($this->maintenanceModel->delete($id)) {
            Log::record(Auth::userId(), "Menghapus laporan kerusakan #$id (Soft Delete)");
            $this->flash('success', 'Laporan kerusakan dipindahkan ke Recycle Bin.');
        } else {
            $this->flash('error', 'Gagal menghapus laporan.');
        }
        $this->redirect('index.php?c=admin&a=reports');
    }
    public function reportRecycleBin()
    {
        $reports = $this->maintenanceModel->getAllDeleted();
        $data = [
            'title' => 'Recycle Bin - Laporan Kerusakan',
            'reports' => $reports
        ];
        $this->view('Admin/reportRecycle', $data);
    }
    public function restoreReport()
    {
        $id = $_GET['id'] ?? 0;
        $this->maintenanceModel->restore($id);
        Log::record(Auth::userId(), "Memulihkan laporan kerusakan #$id");
        $this->flash('success', 'Laporan berhasil dipulihkan.');
        $this->redirect('index.php?c=admin&a=reportRecycleBin');
    }
    public function forceDeleteReport()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=admin&a=reportRecycleBin');
        }
        $id = $_POST['id'] ?? 0;
        $this->maintenanceModel->forceDelete($id);
        Log::record(Auth::userId(), "Menghapus permanen laporan kerusakan #$id");
        $this->flash('success', 'Laporan berhasil dihapus permanen.');
        $this->redirect('index.php?c=admin&a=reportRecycleBin');
    }
    public function payments()
    {
        $branch_id = (Auth::checkRole('admin')) ? Auth::userBranchId() : null;
        $invoices = $this->invoiceModel->getAllPendingVerification($branch_id);
        $data = [
            'title' => 'Verifikasi Pembayaran',
            'invoices' => $invoices
        ];
        $this->view('Admin/payments', $data);
    }
    public function verifyPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=admin&a=payments');
        }
        $id = $_POST['invoice_id'] ?? 0;
        $action = $_POST['action'] ?? '';
        if ($id > 0 && $action === 'approve') {
            $this->invoiceModel->updateStatus($id, 'lunas');
            Log::record(Auth::userId(), "Menyetujui pembayaran tagihan #$id");
            $this->flash('success', 'Pembayaran berhasil diverifikasi (Lunas).');
        } elseif ($id > 0 && $action === 'reject') {
            $this->invoiceModel->updateStatus($id, 'belum_bayar');
            Log::record(Auth::userId(), "Menolak pembayaran tagihan #$id");
            $this->flash('warning', 'Pembayaran ditolak. Status kembali ke Belum Bayar.');
        } else {
            $this->flash('error', 'Aksi tidak valid.');
        }
        $this->redirect('index.php?c=admin&a=payments');
    }
    public function generateInvoices()
    {
        $count = $this->invoiceModel->generateMonthlyInvoices();
        Log::record(Auth::userId(), "Men-generate $count tagihan bulanan");
        $this->flash('success', $count . ' tagihan baru berhasil di-generate untuk bulan ini.');
        $this->redirect('index.php?c=home&a=index');
    }
    public function feedbacks()
    {
        $feedbacks = $this->feedbackModel->getAll();
        $data = [
            'title' => 'Kritik & Saran Masuk',
            'feedbacks' => $feedbacks
        ];
        $this->view('Admin/feedbacks', $data);
    }
    public function destroyFeedback()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=admin&a=feedbacks');
        }
        $id = $_POST['id'] ?? 0;
        $this->feedbackModel->delete($id);
        Log::record(Auth::userId(), "Menghapus feedback #$id (Soft Delete)");
        $this->flash('success', 'Feedback berhasil dipindahkan ke Recycle Bin.');
        $this->redirect('index.php?c=admin&a=feedbacks');
    }
    public function feedbackRecycleBin()
    {
        $feedbacks = $this->feedbackModel->getAllDeleted();
        $data = [
            'title' => 'Recycle Bin - Kritik & Saran',
            'feedbacks' => $feedbacks
        ];
        $this->view('Admin/feedbackRecycle', $data);
    }
    public function restoreFeedback()
    {
        $id = $_GET['id'] ?? 0;
        $this->feedbackModel->restore($id);
        Log::record(Auth::userId(), "Memulihkan feedback #$id");
        $this->flash('success', 'Feedback berhasil dipulihkan.');
        $this->redirect('index.php?c=admin&a=feedbackRecycleBin');
    }
    public function forceDeleteFeedback()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=admin&a=feedbackRecycleBin');
        }
        $id = $_POST['id'] ?? 0;
        $this->feedbackModel->forceDelete($id);
        Log::record(Auth::userId(), "Menghapus permanen feedback #$id");
        $this->flash('success', 'Feedback berhasil dihapus permanen.');
        $this->redirect('index.php?c=admin&a=feedbackRecycleBin');
    }
    public function logs()
    {
        Auth::protectRole('superadmin');
        $logs = $this->logModel->getAll();
        $data = [
            'title' => 'Log Aktivitas Sistem',
            'logs' => $logs
        ];
        $this->view('Admin/logs', $data);
    }
}
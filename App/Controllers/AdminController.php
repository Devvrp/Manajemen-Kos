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
        $reports = $this->maintenanceModel->getAll();
        $data = [
            'title' => 'Kelola Laporan Kerusakan',
            'reports' => $reports
        ];
        $this->view('admin/reports', $data);
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
    public function payments()
    {
        $invoices = $this->invoiceModel->getAllPendingVerification();
        $data = [
            'title' => 'Verifikasi Pembayaran',
            'invoices' => $invoices
        ];
        $this->view('admin/payments', $data);
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
        $this->view('admin/feedbacks', $data);
    }
    public function logs()
    {
        Auth::protectRole('superadmin');
        $logs = $this->logModel->getAll();
        $data = [
            'title' => 'Log Aktivitas Sistem',
            'logs' => $logs
        ];
        $this->view('admin/logs', $data);
    }
}
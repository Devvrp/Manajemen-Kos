<?php

class InvoiceController extends Controller
{
    private $invoiceModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole('penghuni');
        $this->invoiceModel = new Invoice();
    }
    public function index()
    {
        $invoices = $this->invoiceModel->getByUserId(Auth::userId());
        $data = [
            'title' => 'Daftar Tagihan Saya',
            'invoices' => $invoices
        ];
        $this->view('Invoice/index', $data);
    }
    public function pay()
    {
        $id = $_GET['id'] ?? 0;
        $invoice = $this->invoiceModel->findById($id);
        if (!$invoice || $invoice['status_pembayaran'] === 'lunas') {
            $this->flash('error', 'Tagihan tidak valid atau sudah lunas.');
            $this->redirect('index.php?c=invoice&a=index');
        }
        $data = [
            'title' => 'Konfirmasi Pembayaran: ' . htmlspecialchars($invoice['bulan_tagihan']),
            'invoice' => $invoice,
            'errors' => []
        ];
        $this->view('Invoice/pay', $data);
    }
    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=invoice&a=index');
        }
        $id = $_POST['invoice_id'] ?? 0;
        $file = $_FILES['bukti_bayar'] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            $this->flash('error', 'Gagal meng-upload file. Pastikan file tidak rusak.');
            $this->redirect('index.php?c=invoice&a=pay&id=' . $id);
        }
        if ($file['size'] > 2097152) {
            $this->flash('error', 'Ukuran file terlalu besar (Maks 2MB).');
            $this->redirect('index.php?c=invoice&a=pay&id=' . $id);
        }
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $allowedMimes = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($mime, $allowedMimes)) {
            $this->flash('error', 'Format file tidak diizinkan (Hanya JPG, PNG, atau PDF).');
            $this->redirect('index.php?c=invoice&a=pay&id=' . $id);
        }
        $uploadDir = __DIR__ . '/../../Public/uploads/payments/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = 'payment_' . $id . '_' . time() . '.' . $extension;
        $destination = $uploadDir . $newFileName;
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $this->invoiceModel->uploadProof($id, $newFileName);
            $this->flash('success', 'Bukti pembayaran berhasil di-upload. Menunggu verifikasi admin.');
            $this->redirect('index.php?c=invoice&a=index');
        } else {
            $this->flash('error', 'Gagal memindahkan file.');
            $this->redirect('index.php?c=invoice&a=pay&id=' . $id);
        }
    }
}
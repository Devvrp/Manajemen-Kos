<?php

class Invoice
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getByUserId($userId)
    {
        $stmt = $this->db->prepare("
            SELECT i.* FROM invoices i
            JOIN contracts c ON i.contract_id = c.contract_id
            WHERE c.user_id = ?
            ORDER BY i.bulan_tagihan DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM invoices WHERE invoice_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function getAllPendingVerification()
    {
        $stmt = $this->db->prepare("
            SELECT i.*, u.nama_lengkap, r.nomor_kamar
            FROM invoices i
            JOIN contracts c ON i.contract_id = c.contract_id
            JOIN users u ON c.user_id = u.user_id
            JOIN rooms r ON c.room_id = r.room_id
            WHERE i.status_pembayaran = 'menunggu_verifikasi'
            ORDER BY i.bulan_tagihan DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function uploadProof($id, $fileName)
    {
        $stmt = $this->db->prepare("UPDATE invoices SET file_bukti_bayar = ?, status_pembayaran = 'menunggu_verifikasi' WHERE invoice_id = ?");
        return $stmt->execute([$fileName, $id]);
    }
    public function updateStatus($id, $status)
    {
        $tanggalLunas = ($status === 'lunas') ? date('Y-m-d H:i:s') : null;
        $fileBukti = ($status === 'belum_bayar' || $status === 'lunas') ? null : 'file_bukti_bayar';
        $sql = "UPDATE invoices SET status_pembayaran = ?, tanggal_lunas = ?";
        if($fileBukti === null) $sql .= ", file_bukti_bayar = NULL";
        $sql .= " WHERE invoice_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $tanggalLunas, $id]);
    }
    public function generateMonthlyInvoices()
    {
        $contractModel = new Contract();
        $activeContracts = $contractModel->getAllActiveContracts();
        $currentMonth = date('Y-m');
        $count = 0;
        foreach ($activeContracts as $contract) {
            $stmtCheck = $this->db->prepare("SELECT 1 FROM invoices WHERE contract_id = ? AND bulan_tagihan = ?");
            $stmtCheck->execute([$contract['contract_id'], $currentMonth]);
            if ($stmtCheck->fetch()) {
                continue;
            }
            $roomStmt = $this->db->prepare("SELECT harga_bulanan FROM rooms WHERE room_id = ?");
            $roomStmt->execute([$contract['room_id']]);
            $room = $roomStmt->fetch();
            $harga = $room['harga_bulanan'];
            $stmtInsert = $this->db->prepare("
                INSERT INTO invoices (contract_id, bulan_tagihan, jumlah_tagihan_pokok, total_tagihan, status_pembayaran)
                VALUES (?, ?, ?, ?, 'belum_bayar')
            ");
            $stmtInsert->execute([$contract['contract_id'], $currentMonth, $harga, $harga]);
            $count++;
        }
        return $count;
    }
}
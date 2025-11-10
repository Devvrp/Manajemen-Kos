<?php

class Contract
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getActiveContractByUserId($userId)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, r.nomor_kamar, r.harga_bulanan
            FROM contracts c
            JOIN rooms r ON c.room_id = r.room_id
            WHERE c.user_id = ? AND c.status_kontrak = 'aktif'
            LIMIT 1
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
    public function getAllActiveContracts()
    {
        $stmt = $this->db->prepare("
            SELECT c.*, u.nama_lengkap, r.nomor_kamar
            FROM contracts c
            JOIN users u ON c.user_id = u.user_id
            JOIN rooms r ON c.room_id = r.room_id
            WHERE c.status_kontrak = 'aktif'
            ORDER BY u.nama_lengkap
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function create($data)
    {
        $this->db->beginTransaction();
        try {
            $stmt1 = $this->db->prepare("INSERT INTO contracts (user_id, room_id, tanggal_masuk, status_kontrak) VALUES (?, ?, ?, 'aktif')");
            $stmt1->execute([$data['user_id'], $data['room_id'], $data['tanggal_masuk']]);
            $stmt2 = $this->db->prepare("UPDATE rooms SET status = 'terisi' WHERE room_id = ?");
            $stmt2->execute([$data['room_id']]);
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    public function endContract($id)
    {
        $this->db->beginTransaction();
        try {
            $stmtFind = $this->db->prepare("SELECT room_id FROM contracts WHERE contract_id = ?");
            $stmtFind->execute([$id]);
            $contract = $stmtFind->fetch();
            $roomId = $contract['room_id'];
            $stmt1 = $this->db->prepare("UPDATE contracts SET status_kontrak = 'selesai', tanggal_keluar = NOW() WHERE contract_id = ?");
            $stmt1->execute([$id]);
            $stmt2 = $this->db->prepare("UPDATE rooms SET status = 'tersedia' WHERE room_id = ?");
            $stmt2->execute([$roomId]);
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
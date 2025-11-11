<?php

class Maintenance
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getByUserId($userId)
    {
        $stmt = $this->db->prepare("
            SELECT m.*, r.nomor_kamar 
            FROM maintenance_req m
            JOIN rooms r ON m.room_id = r.room_id
            WHERE m.user_id = ? 
            ORDER BY m.tanggal_lapor DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function getAll($branch_id = null)
    {
        $sql = "SELECT m.*, r.nomor_kamar, u.nama_lengkap 
                FROM maintenance_req m
                JOIN rooms r ON m.room_id = r.room_id
                JOIN users u ON m.user_id = u.user_id";
        $params = [];
        if ($branch_id) {
            $sql .= " WHERE r.branch_id = ?";
            $params[] = $branch_id;
        }
        $sql .= " ORDER BY m.status_laporan ASC, m.tanggal_lapor DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM maintenance_req WHERE request_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO maintenance_req (user_id, room_id, judul_laporan, deskripsi_kerusakan, status_laporan, tanggal_lapor) 
            VALUES (?, ?, ?, ?, 'dilaporkan', NOW())
        ");
        return $stmt->execute([
            $data['user_id'],
            $data['room_id'],
            $data['judul_laporan'],
            $data['deskripsi_kerusakan']
        ]);
    }
    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE maintenance_req SET status_laporan = ? WHERE request_id = ?");
        return $stmt->execute([$status, $id]);
    }
    public function getActiveContract($userId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM contracts 
            WHERE user_id = ? AND status_kontrak = 'aktif' 
            LIMIT 1
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
}
<?php

class Announcement
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getAll($branch_id = null, $limit = 100)
    {
        $sql = "SELECT a.*, u.nama_lengkap, b.nama_cabang 
                FROM announcements a
                JOIN users u ON a.user_id = u.user_id
                LEFT JOIN branches b ON a.branch_id = b.branch_id
                WHERE a.deleted_at IS NULL";
        $params = [];
        if ($branch_id) {
            $sql .= " AND (a.branch_id = ? OR a.branch_id IS NULL)";
            $params[] = $branch_id;
        }
        $sql .= " ORDER BY a.created_at DESC LIMIT ?";
        $params[] = $limit;
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    public function getAllDeleted()
    {
        $stmt = $this->db->prepare("
            SELECT a.*, u.nama_lengkap, b.nama_cabang 
            FROM announcements a
            JOIN users u ON a.user_id = u.user_id
            LEFT JOIN branches b ON a.branch_id = b.branch_id
            WHERE a.deleted_at IS NOT NULL
            ORDER BY a.deleted_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM announcements WHERE announcement_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($data)
    {
        $branch_id = !empty($data['branch_id']) ? $data['branch_id'] : null;
        $stmt = $this->db->prepare("INSERT INTO announcements (user_id, branch_id, judul, isi_pengumuman) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['user_id'],
            $branch_id,
            $data['judul'],
            $data['isi_pengumuman']
        ]);
    }
    public function update($id, $data)
    {
        $branch_id = !empty($data['branch_id']) ? $data['branch_id'] : null;
        $stmt = $this->db->prepare("UPDATE announcements SET judul = ?, isi_pengumuman = ?, branch_id = ? WHERE announcement_id = ?");
        return $stmt->execute([
            $data['judul'],
            $data['isi_pengumuman'],
            $branch_id,
            $id
        ]);
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE announcements SET deleted_at = NOW() WHERE announcement_id = ?");
        return $stmt->execute([$id]);
    }
    public function restore($id)
    {
        $stmt = $this->db->prepare("UPDATE announcements SET deleted_at = NULL WHERE announcement_id = ?");
        return $stmt->execute([$id]);
    }
    public function forceDelete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM announcements WHERE announcement_id = ?");
        return $stmt->execute([$id]);
    }
}
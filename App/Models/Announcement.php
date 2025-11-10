<?php

class Announcement
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getAll($limit = 100)
    {
        $stmt = $this->db->prepare("
            SELECT a.*, u.nama_lengkap 
            FROM announcements a
            JOIN users u ON a.user_id = u.user_id
            ORDER BY a.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
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
        $stmt = $this->db->prepare("INSERT INTO announcements (user_id, judul, isi_pengumuman) VALUES (?, ?, ?)");
        return $stmt->execute([
            $data['user_id'],
            $data['judul'],
            $data['isi_pengumuman']
        ]);
    }
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE announcements SET judul = ?, isi_pengumuman = ? WHERE announcement_id = ?");
        return $stmt->execute([
            $data['judul'],
            $data['isi_pengumuman'],
            $id
        ]);
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM announcements WHERE announcement_id = ?");
        return $stmt->execute([$id]);
    }
}
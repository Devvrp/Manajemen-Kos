<?php

class Feedback
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO feedbacks (user_id, subjek, isi_pesan) VALUES (?, ?, ?)");
        return $stmt->execute([
            $data['user_id'],
            $data['subjek'],
            $data['isi_pesan']
        ]);
    }
    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT f.*, u.nama_lengkap, u.email
            FROM feedbacks f
            JOIN users u ON f.user_id = u.user_id
            WHERE f.deleted_at IS NULL
            ORDER BY f.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getAllDeleted()
    {
        $stmt = $this->db->prepare("
            SELECT f.*, u.nama_lengkap, u.email
            FROM feedbacks f
            JOIN users u ON f.user_id = u.user_id
            WHERE f.deleted_at IS NOT NULL
            ORDER BY f.deleted_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE feedbacks SET deleted_at = NOW() WHERE feedback_id = ?");
        return $stmt->execute([$id]);
    }
    public function restore($id)
    {
        $stmt = $this->db->prepare("UPDATE feedbacks SET deleted_at = NULL WHERE feedback_id = ?");
        return $stmt->execute([$id]);
    }
    public function forceDelete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM feedbacks WHERE feedback_id = ?");
        return $stmt->execute([$id]);
    }
}
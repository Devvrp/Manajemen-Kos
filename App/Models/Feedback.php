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
            ORDER BY f.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
<?php

class ActivityLog
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function create($userId, $action)
    {
        $stmt = $this->db->prepare("INSERT INTO activity_logs (user_id, action_description, timestamp) VALUES (?, ?, NOW())");
        return $stmt->execute([$userId, $action]);
    }
    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT l.*, u.nama_lengkap
            FROM activity_logs l
            JOIN users u ON l.user_id = u.user_id
            ORDER BY l.timestamp DESC
            LIMIT 200
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
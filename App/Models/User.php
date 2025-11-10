<?php

class User
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND deleted_at IS NULL");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ? AND deleted_at IS NULL");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($data)
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (nama_lengkap, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nama_lengkap'],
            $data['email'],
            $hashedPassword,
            $data['role'] ?? 'penghuni',
            $data['status'] ?? 'aktif'
        ]);
    }
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE deleted_at IS NULL ORDER BY nama_lengkap");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE users SET nama_lengkap = ?, email = ?, role = ?, status = ? WHERE user_id = ?");
        return $stmt->execute([
            $data['nama_lengkap'],
            $data['email'],
            $data['role'],
            $data['status'],
            $id
        ]);
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE users SET deleted_at = NOW() WHERE user_id = ?");
        return $stmt->execute([$id]);
    }
    public function getAllDeleted()
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function restore($id)
    {
        $stmt = $this->db->prepare("UPDATE users SET deleted_at = NULL WHERE user_id = ?");
        return $stmt->execute([$id]);
    }
    public function forceDelete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = ? AND deleted_at IS NOT NULL");
        return $stmt->execute([$id]);
    }
    public function getAvailableTenants()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE role = 'penghuni' 
            AND status = 'aktif' 
            AND deleted_at IS NULL
            AND user_id NOT IN (
                SELECT user_id FROM contracts WHERE status_kontrak = 'aktif'
            )
            ORDER BY nama_lengkap
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
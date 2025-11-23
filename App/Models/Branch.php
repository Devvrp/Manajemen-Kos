<?php

class Branch
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM branches WHERE deleted_at IS NULL ORDER BY nama_cabang ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getAllDeleted()
    {
        $stmt = $this->db->prepare("SELECT * FROM branches WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM branches WHERE branch_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO branches (nama_cabang, alamat_cabang) VALUES (?, ?)");
        return $stmt->execute([
            $data['nama_cabang'],
            $data['alamat_cabang']
        ]);
    }
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE branches SET nama_cabang = ?, alamat_cabang = ? WHERE branch_id = ?");
        return $stmt->execute([
            $data['nama_cabang'],
            $data['alamat_cabang'],
            $id
        ]);
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE branches SET deleted_at = NOW() WHERE branch_id = ?");
        return $stmt->execute([$id]);
    }
    public function restore($id)
    {
        $stmt = $this->db->prepare("UPDATE branches SET deleted_at = NULL WHERE branch_id = ?");
        return $stmt->execute([$id]);
    }
    public function forceDelete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM branches WHERE branch_id = ?");
        return $stmt->execute([$id]);
    }
}
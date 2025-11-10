<?php

class Room
{
    private $db;
    private $qb;
    private $table = 'rooms';
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->qb = new QueryBuilder($this->db);
    }
    public function getAll()
    {
        return $this->qb->table($this->table)
                    ->orderBy('nomor_kamar', 'ASC')
                    ->get();
    }
    public function findById($id)
    {
        return $this->qb->table($this->table)
                    ->where('room_id', '=', $id)
                    ->first();
    }
    public function create($data)
    {
        $insertData = [
            'nomor_kamar' => $data['nomor_kamar'],
            'tipe_kamar' => $data['tipe_kamar'],
            'harga_bulanan' => $data['harga_bulanan'],
            'status' => $data['status'] ?? 'tersedia'
        ];
        return $this->qb->table($this->table)->insert($insertData);
    }
    public function update($id, $data)
    {
        $updateData = [
            'nomor_kamar' => $data['nomor_kamar'],
            'tipe_kamar' => $data['tipe_kamar'],
            'harga_bulanan' => $data['harga_bulanan'],
            'status' => $data['status']
        ];
        $stmt = $this->db->prepare("UPDATE rooms SET nomor_kamar = ?, tipe_kamar = ?, harga_bulanan = ?, status = ? WHERE room_id = ?");
        return $stmt->execute([
            $data['nomor_kamar'],
            $data['tipe_kamar'],
            $data['harga_bulanan'],
            $data['status'],
            $id
        ]);
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM rooms WHERE room_id = ?");
        return $stmt->execute([$id]);
    }
    public function getAvailableRooms()
    {
        return $this->qb->table($this->table)
                    ->where('status', '=', 'tersedia')
                    ->orderBy('nomor_kamar', 'ASC')
                    ->get();
    }
}
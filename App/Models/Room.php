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
    public function getAll($filters = [])
    {
        $query = $this->qb->table($this->table)
                        ->select(['rooms.*', 'branches.nama_cabang'])
                        ->join('branches', 'rooms.branch_id', '=', 'branches.branch_id');
        if (!empty($filters['branch_id'])) {
            $query->where('rooms.branch_id', '=', $filters['branch_id']);
        }
        if (!empty($filters['harga_max'])) {
            $query->where('harga_bulanan', '<=', $filters['harga_max']);
        }
        if (!empty($filters['fasilitas'])) {
            $query->where('fasilitas', 'LIKE', '%' . $filters['fasilitas'] . '%');
        }
        return $query->orderBy('nomor_kamar', 'ASC')->get();
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
            'branch_id' => $data['branch_id'],
            'nomor_kamar' => $data['nomor_kamar'],
            'tipe_kamar' => $data['tipe_kamar'],
            'fasilitas' => $data['fasilitas'],
            'harga_bulanan' => $data['harga_bulanan'],
            'status' => $data['status'] ?? 'tersedia'
        ];
        return $this->qb->table($this->table)->insert($insertData);
    }
    public function update($id, $data)
    {
        $updateData = [
            'branch_id' => $data['branch_id'],
            'nomor_kamar' => $data['nomor_kamar'],
            'tipe_kamar' => $data['tipe_kamar'],
            'fasilitas' => $data['fasilitas'],
            'harga_bulanan' => $data['harga_bulanan'],
            'status' => $data['status']
        ];
        return $this->qb->table($this->table)->update('room_id', $id, $updateData);
    }
    public function delete($id)
    {
        return $this->qb->table($this->table)->delete('room_id', $id);
    }
    public function getAvailableRooms($branch_id)
    {
        return $this->qb->table($this->table)
                    ->where('status', '=', 'tersedia')
                    ->where('branch_id', '=', $branch_id)
                    ->orderBy('nomor_kamar', 'ASC')
                    ->get();
    }
}
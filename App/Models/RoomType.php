<?php

class RoomType
{
    private $db;
    private $qb;
    private $table = 'room_types';
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->qb = new QueryBuilder($this->db);
    }
    public function getAll()
    {
        return $this->qb->table($this->table)->get();
    }
    public function findById($id)
    {
        return $this->qb->table($this->table)->where('type_id', '=', $id)->first();
    }
    public function create($data)
    {
        return $this->qb->table($this->table)->insert([
            'nama_tipe' => $data['nama_tipe'],
            'fasilitas_default' => $data['fasilitas_default'],
            'harga_default' => $data['harga_default']
        ]);
    }
    public function update($id, $data)
    {
        return $this->qb->table($this->table)->update('type_id', $id, [
            'nama_tipe' => $data['nama_tipe'],
            'fasilitas_default' => $data['fasilitas_default'],
            'harga_default' => $data['harga_default']
        ]);
    }
    public function delete($id)
    {
        return $this->qb->table($this->table)->delete('type_id', $id);
    }
}
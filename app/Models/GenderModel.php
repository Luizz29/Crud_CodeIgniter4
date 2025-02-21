<?php

namespace App\Models;

use CodeIgniter\Model;

class GenderModel extends Model
{
    protected $table = 'gender';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'jenis', 'created_at', 'updated_at'];

    public function deleteMultipleForm($id)
    {
        $this->db->table('products')->delete(['id' => $id]);
    }
    public function getGenderData()
    {
        return $this->select("id, username, jenis, DATE(created_at) as created_at, DATE(updated_at) as updated_at")
            ->findAll();
    }
    public function getGender()
    {
        return $this->select('jenis, COUNT(*) as total')
            ->groupBy('jenis')
            ->findAll();
    }
}

<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price', 'description', 'created_at', 'options', 'condition' , 'category'];

    public function deleteMultipleForm($id)
    {
        $this->db->table('products')->delete(['id' => $id]);
    }
    
}
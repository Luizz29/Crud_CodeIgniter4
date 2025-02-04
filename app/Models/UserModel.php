<?php
// app/Models/UserModel.php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'msuser';
    protected $primaryKey = 'userid';
    protected $allowedFields = ['usernm', 'password', 'createddate', 'createdby', 'updateddate', 'updatedby'];
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    
    
    // Nonaktifkan timestamps bawaan CI4
    protected $useTimestamps = false;
    
    // Tambahkan validasi jika diperlukan
    protected $validationRules = [
        'usernm' => 'required|min_length[3]',
        'password' => 'required|min_length[6]'
        
    ];

    public function getUsername($username, $password){
        return $this->where('usernm', $username)->where('password', $password)->first();
    }
}
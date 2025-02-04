<?php

namespace App\Models;


use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'msuser';
    protected $primaryKey = 'userid';
    protected $allowedFields = ['usernm', 'password', 'createddate', 'createdby', 'updateddate', 'updatedby'];
    protected $useTimestamps = true;


    public function getUserByUsername($username)
    {
        return $this->where('usernm', $username)->first();
    }
}

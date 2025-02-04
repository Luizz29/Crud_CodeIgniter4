<?php
namespace App\Models;
use CodeIgniter\Model;

class MsUserModel extends Model
{
    protected $table = 'msuser';
    protected $primaryKey = 'userid';
    protected $allowedFields = ['userid','usernm', 'password', 'createddate', 'createdby', 'updateddate', 'updatedby'];
    protected $useTimestamps = false;

    public function getData(){
        return $this->findAll();
    }

    public function insertData($data){
        return $this->insert($data);
    }
    public function getUser($username, $password)
    {
        return $this->where('usernm', $username)->where('password', $password)->first();
    }

    public function saveUser($data)
    {
        return $this->insert($data);
    }

    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->delete($id);
    }
    public function getOneData($param = '', $fields = 'usernm')
{
    if ($param != '') {
        $this->where($fields, $param);
    }
    return $this->get();
}

   

}



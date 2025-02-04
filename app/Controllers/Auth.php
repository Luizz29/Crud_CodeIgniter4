<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        $session = session();
        
        $model = new UserModel();
        
        $username = $this->request->getPost('usernm');
        $password = md5($this->request->getPost('password')); // Hash pakai md5
        
        $user = $model->getUsername($username, $password); 
        if ($user) {
            $session->set([
                'userid' => $user['userid'],
                'usernm' => $user['usernm'],    
                'logged_in' => true,
            ]);
            return $this->response->setJSON(['status' => 'success']); 
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Username atau password salah.']);
        }
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
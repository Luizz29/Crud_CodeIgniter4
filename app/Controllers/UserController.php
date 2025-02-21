<?php

namespace App\Controllers;

use App\Models\MsUserModel;
use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;


class UserController extends BaseController
{
    protected $MsUserModel;
    protected $db;
    public function __construct()
    {
        $this->MsUserModel = new MsUserModel();
        $this->db = \Config\Database::connect();
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
    }
    public function index()
    {
        return view('user_view');
    }

    public function getUsers()
    {
        $data = $this->MsUserModel->getData();
        return $this->response->setJSON($data);
    }


    public function addUser()
    {
        $this->db->transBegin();
        try {
            $username = $this->request->getPost('usernm');
            $password = md5($this->request->getPost('password'));

            $user = $this->MsUserModel->getOneData($username)->getRowArray();
            if ($user) {
                $data = [
                    'status' => 'error',
                    'message' => 'Username sudah digunakan'
                ];
                return $this->response->setJSON($data);
            }
            if ($username == '' || $password == '') {
                $data = [
                    'status' => 'error',
                    'message' => 'Username dan Password tidak boleh kosong'
                ];
                return $this->response->setJSON($data);
            }
            $createdBy = session()->get('userid');
            $data = [
                'usernm' => $this->request->getPost('usernm'),
                'password' => md5($this->request->getPost('password')),
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => $createdBy,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => $createdBy
            ];
            $this->MsUserModel->insertData($data);
            if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
                $data = [
                    'status' => 'error',
                    'message' => 'Gagal Menambahkan Data'
                ];
                return $this->response->setJSON($data);
            }
            $data = [
                'status' => 'success',
                'message' => 'Data Berhasil Ditambahkan'
            ];
            $this->db->transCommit();
            return $this->response->setJSON($data);
        } catch (DatabaseException $e) {
            $this->db->transRollback();
            $data = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return $this->response->setJSON($data);
        }
    }


    public function updateUser()
    {

        $this->db->transBegin();
        try {
            $userid = $this->request->getPost('userid');
            $username = $this->request->getPost('usernm');
            $password = $this->request->getPost('password');



            $dataLama = $this->MsUserModel->getOneData($userid, 'userid')->getRowArray();
            if (!$dataLama) {
                $response = [
                    'status' => 'error',
                    'message' => 'User tidak ditemukan'
                ];
                return $this->response->setJSON($response);
            }

            $cekUser = $this->MsUserModel->getOneData($username)->getRowArray();
            if ($cekUser && $cekUser['userid'] != $userid) {
                $response = [
                    'status' => 'error',
                    'message' => 'Username sudah digunakan oleh pengguna lain'
                ];
                return $this->response->setJSON($response);
            }

            $data = [
                'usernm' => $username,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => session()->get('userid')
            ];

            if (!empty($password)) {
                $hashedPassword = md5($password);
                $data['password'] = $hashedPassword;
            }
            //menghitung jumlah total baris yang dikembalikan query 
            // $user = $this->MsUserModel->getOneData($username)->getNumRows();
            // if ($user) {
            //     $data['status'] = 'error';
            //     $data['message'] = 'Username sudah digunakan';
            //     return $this->response->setJSON($data);
            // }

            $this->MsUserModel->updateUser($userid, $data);
            if ($this->db->transStatus() === FALSE) {
                $response = [
                    'status' => 'error',
                    'message' => 'Gagal Mengubah Data'
                ];
                $this->db->transRollback();
                return $this->response->setJSON($response);
            }
            $response = [
                'status' => 'success',
                'message' => 'Data Berhasil Diubah',
            ];
            $this->db->transCommit();
            return $this->response->setJSON($response);
        } catch (DatabaseException $e) {
            $this->db->transRollback();
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return $this->response->setJSON($response);
        }
    }

    public function deleteUser()
    {
        $userid = $this->request->getPost('userid');
        $this->db->transBegin();
        try {
            $this->MsUserModel->deleteUser($userid);
            if ($this->db->transStatus() === FALSE) {
                $data = [
                    'status' => 'error',
                    'message' => 'Gagal Menghapus Data'
                ];
                $this->db->transRollback();
                return $this->response->setJSON($data);
            }

            $data = [
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus',
                'userid' => $userid
            ];

            $this->db->transCommit();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            $this->db->transRollback();
            $data = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
    //buat agar me return view dari register


    public function registerUser()
    {
        return view('register');
    }
}

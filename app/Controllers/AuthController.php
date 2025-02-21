<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['url', 'form', 'session']);
    }

    // Halaman Registrasi
    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $usernm = $this->request->getPost('usernm');
            $password = $this->request->getPost('password');

            // Cek apakah username sudah ada
            if ($this->userModel->where('usernm', $usernm)->first()) {
                return redirect()->to('/Crud_CodeIgniter4/register')->with('error', 'Username sudah terdaftar.');
            }

            $data = [
                'usernm'      => $usernm,
                'password'    => md5($password), // Hashing password menggunakan md5
                'createddate' => date('Y-m-d H:i:s'),
                'createdby'   => 1 // Atur sesuai kebutuhan, misalnya ID admin atau 0
            ];

            if ($this->userModel->insert($data)) {
                return redirect()->to('/Crud_CodeIgniter4/login')->with('success', 'Registrasi berhasil. Silakan login.');
            } else {
                return redirect()->to('/Crud_CodeIgniter4/register')->with('error', 'Terjadi kesalahan, coba lagi.');
            }
        }

        return view('auth/register');
    }

    // Halaman Login
    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $usernm = $this->request->getPost('usernm');
            $password = md5($this->request->getPost('password'));

            $user = $this->userModel->where('usernm', $usernm)->first();

            if ($user && $user['password'] === $password) {
                session()->set([
                    'userid'    => $user['userid'],
                    'usernm'    => $user['usernm'],
                    'isLoggedIn' => true
                ]);

                return redirect()->to('/dashboard'); // Ganti '/dashboard' dengan halaman setelah login
            } else {
                return redirect()->to('/login')->with('error', 'Username atau password salah.');
            }
        }

        return view('auth/login');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout.');
    }
}

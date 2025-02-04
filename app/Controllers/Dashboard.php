<?php

namespace App\Controllers;

use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        // Mengecek apakah user sudah login berdasarkan session
        $session = session();
        if (!$session->get('logged_in')) {
            // Jika tidak, redirect ke halaman login
            return redirect()->to('/login');
        }
    }

    public function index()
    {
        return view('/login');
    }
}

<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Auth extends BaseConfig
{
    // Pilih grup koneksi database yang akan digunakan oleh MythAuth
    public $databaseGroup = 'default'; // Ganti dengan 'userdb' jika menggunakan grup koneksi lain
    
    // Pengaturan lain terkait otentikasi, jika diperlukan
}

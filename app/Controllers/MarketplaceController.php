<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MarketplaceModel;

class MarketplaceController extends BaseController
{
    protected $marketplaceModel;

    public function __construct()
    {
        $this->marketplaceModel = new MarketplaceModel();
    }
    public function index()
    {

        $data = [
            'title' => 'User',
            'user' => $this->marketplaceModel->findAll()
        ];
        return view('marketplace/index', $data);
    }
}

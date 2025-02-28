<?php

namespace App\Models;

use CodeIgniter\Model;

class MarketplaceModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price', 'description', 'created_at', 'options', 'condition', 'category'];
    protected $useTimestamps = false;
}

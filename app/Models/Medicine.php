<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'barcode',
        'category_id',
        'supplier_id',
        'price',
        'cost_price',
        'stock_quantity',
        'expiry_date',
    ];
}

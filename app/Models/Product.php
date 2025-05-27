<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'purchase_price',
        'selling_price',
        'stock_quantity',
        'min_stock_level',
    ];

    public function saleItems()
{
    return $this->hasMany(SaleItem::class);
}

}

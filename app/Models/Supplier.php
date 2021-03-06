<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = ["name"];

    public function products(){
        return $this->belongsToMany(\App\Models\Product::class, "supplier_products", "supply_id", "product_id");
    }
}

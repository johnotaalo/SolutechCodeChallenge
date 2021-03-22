<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ["order_number"];

    public function products(){
    	return $this->belongsToMany(\App\Models\Product::class, "order_details", "order_id", "product_id");
    }

    public function productpivot(){
        return $this->hasMany(\App\Models\OrderDetail::class, "order_id");
    }
}

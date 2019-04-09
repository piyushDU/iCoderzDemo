<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name', 'quantity', 'category_id', 'description', 'website_url'
    ];

     /**
     * Get the category for the product category.
     */
    public function category()
    {
        return $this->hasOne('App\ProductCategory',  'id', 'category_id');
    }
}

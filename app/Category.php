<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'description', 'category_id'];

    public function products()
    {
        return $this->hasMany(Product::class); // relaction hasMany pour lié plusieurs produits a une catégorie
    }
}

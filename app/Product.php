<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $fillable = ['title', 'description', 'price', 'size', 'url_image', 'status', 'code', 'reference', 'genre', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function scopeRefsProducts($query, int $categoryId, int $limit = 3)
    // fonction qui permet de renvoyer les références produits par la catégorie
    {
        return $query
            ->where('category_id', '=', $categoryId)
            ->orderBy('id', 'DESC')
            ->limit($limit);
    }
    public static function scopeGetSizes()
    // fonction static qui permet de renvoyer les enums sizes contenu en base de donnée
    {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM products WHERE Field = 'size'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum = array_merge([...$enum, $v]);
        }
        return $enum;
    }
    public static function scopeGetCodes()
    //  fonction static qui permet de renvoyer les enums codes contenu en base de donnée
    {
        $codes = DB::select(DB::raw("SHOW COLUMNS FROM products WHERE Field = 'code'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $codes, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum = array_merge([...$enum, $v]);
        }
        return $enum;
    }
}

<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Cache;

class FrontController extends Controller
{
    public function __construct()
    {
        // récupère les catégories correspondante et les place dans le menu
        view()->composer('partials.menu', function ($view) {
            $categories = Category::pluck('title', 'id')->all();
            $view->with('categories', $categories);
        });
    }
    private $paginate = 6;
    // fonction pour montrer un produit via l'id
    public function showProductsById(int $id)
    {
        // $id récupéré dans la route
        $product = Product::with('category')->find($id);
        // fonction refsProducts pour récupéré les produits en référence à la catégorie actuelle 
        $images = Product::refsProducts($product->category_id)->get();
        // fonction getSizes qui permet de renvoyer les enums sizes contenu en base de donnée
        $sizes = Product::getSizes();
        return view('front.show', [
            'product' => $product,
            'images' => $images,
            'sizes' => $sizes
        ]);
    }
    public function showProductsBySoldes()
    {
        // récupérer les produits par soldes
        $products = Product::with('category')->where('code', '=', 'solde')->paginate($this->paginate);
        // on récupère le nom du code correspondant
        $soldes = Product::with('category')->where('code', '=', 'solde')->first();
        // on compte les produits sortants par soldes
        $count = Product::with('category')->where(
            'code',
            '=',
            'solde'
        )->count();
        return view('front.soldes', [
            'products' => $products,
            'soldes' => $soldes,
            'count' => $count
        ]);
    }
    public function showProductsByCategory(int $id)
    {
        // récupérer les produits par catégories sélectionnées
        $products = Product::with('category')->where('category_id', '=', $id, 'AND', 'status', '=', 'published')->paginate($this->paginate);
        // on récupère la catégorie correspondante
        $categories = Product::with('category')->where('category_id', '=', $id)->first();
        // on compte tout les produits par catégorie et status publié
        $count = Product::where('category_id', '=', $id, 'AND', 'status', '=', 'published')->count();
        return view('front.category', [
            'products' => $products,
            'count' => $count,
            'categories' => $categories
        ]);
    }
    // fonction pour récupéré tout les produits
    public function showAllProducts()
    {
        // on récupère tout les produits qui ont comme status publié et on les trie par les plus récents
        $products = Product::where('status', '=', 'published')->orderBy('id', 'DESC')->paginate($this->paginate);
        // on compte tout les produits par status publié
        $count = Product::where('status', '=', 'published')->count();
        return view('front.index', [
            'products' => $products,
            'count' => $count
        ]);
    }
}

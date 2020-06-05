<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BackController extends Controller
{
    public function __construct()
    {
        view()->composer('partials.menu', function ($view) {
            $categories = Category::pluck('title', 'id');
            $view->with('categories', $categories);
        });
    }
    private $paginate = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate($this->paginate);
        return view('back.admin.index', ['products' => $products]);
    }
    public function create()
    {
        $categories = Category::pluck('title', 'id'); // ['id' => 'name']
        $sizes = Product::getSizes();
        $codes = Product::getCodes();
        return view('back.admin.create', [
            'categories' => $categories,
            'sizes' => $sizes,
            'codes' => $codes
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // si category_id == 1 alors le genre est homme sinon femme
        $request['category_id'] == "1" ? $request['genre'] = 'Homme' : $request['genre'] = 'Femme';
        // pour les validations vous avez les rules
        // insert les données en base il faut préciser cela dans les fillables 
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'genre' => 'required|string',
            'size' => 'required|in:46,48,50,52',
            'url_image' => 'required|image',
            'status' => 'required|in:published,unpublished',
            'reference' => 'required|size:13',
            'code' => 'required|in:new,solde',
        ]);
        // une fois le product créé en base de données Laravel crée un objet product
        $product = Product::create($request->all());
        if ($request->file('url_image')) {

            // enregistre dans le store l'image et en même temps on récupère le
            // nom de l'image créé par Laravel, nom sécurisé
            // 1. Pas d'écrasement d'image avec le même nom.
            // 2. Pas d'injection de script dans le nom de l'image.
            $link = $request->file('url_image')->store('');
            // on vérifie le genre est on déplace le fichier dans le dossier correspondant
            if ($request['genre'] == 'Femme') {
                Storage::move($link, 'femmes/' . $link);
            }
            if ($request['genre'] == 'Homme') {
                Storage::move($link, 'hommes/' . $link);
            }
            // Création du produit dans la base de donnée via le model
            $product->url_image = $link;
            // Sauvegarde du nouveau document enregistré en base de donnée
            $product->save();
        }
        Cache::flush();

        // with permet de créer un flash message enregistrer dans la classe Session clé/valeur :
        return redirect()->route('admin.index')->with('message', [
            'type' => 'alert-success',
            'content' => 'success create book'
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        // $id récupéré dans la route
        $product = Product::find($id);
        return view('back.admin.show', ['product' => $product]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::pluck('title', 'id'); // ['id' => 'title']
        $sizes = Product::getSizes();
        $codes = Product::getCodes();
        $product = Product::find($id);

        return view('back.admin.edit', [
            'product' => $product,
            'categories' => $categories,
            'sizes' => $sizes,
            'codes' => $codes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  int $id)
    {

        $request['category_id'] == "1" ? $request['genre'] = 'Homme' : $request['genre'] = 'Femme';
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'genre' => 'required|string',
            'size' => 'required|in:46,48,50,52',
            'status' => 'required|in:published,unpublished',
            'reference' => 'required|size:13',
            'code' => 'required|in:new,solde',
            'url_image' => 'image|max:3000', // On n'oblige pas le changement d'image
        ]);
        $product = Product::with('category')->find($id);
        if ($request->delete_picture) {
            $this->deletePicture($product);
        }
        $product->update($request->all());
        // Gestion de l'image
        if ($request->file('url_image')) {
            // on supprime physiquement l'image dans le dossier correspondant
            if ($product->genre == 'Homme') {
                Storage::disk('homme_images')->delete($product->url_image);
            }
            if ($product->genre == 'Femme') {
                Storage::disk('femme_images')->delete($product->url_image);
            }
            // on stock la nouvelle image dans la bdd
            $link = $request->file('url_image')->store('');
            // on vérifie le genre est on déplace le fichier dans le dossier correspondant
            if ($request['genre'] == 'Femme') {
                Storage::move($link, 'femmes/' . $link);
            }
            if ($request['genre'] == 'Homme') {
                Storage::move($link, 'hommes/' . $link);
            }
            // on récupère le champ "url_image" et on le remplace par la nouvelle url de l'image
            $product->url_image = $link;
            $product->save();
        }
        Cache::flush();

        return redirect()->route('admin.index')->with('message', [
            'type' => 'alert-success',
            'content' => 'success update book'
        ]);
    }

    /**
     * Remove picture
     * 
     * @param  Product $product
     * @return void
     */
    private function deletePicture($product): void
    {

        if ($product->url_image) {
            // on supprime physiquement l'image dans le répértoire correspondant en récupérant le genre stocké en base de donnée
            if ($product->genre == 'Homme') {
                Storage::disk('homme_images')->delete($product->url_image);
            }
            if ($product->genre == 'Femme') {
                Storage::disk('femme_images')->delete($product->url_image);
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $product = Product::with('category')->where('id', $id)->first();
        $this->deletePicture($product);
        // on supprime le document dans la base de donnée
        $product->delete();
        Cache::flush();

        return redirect()->route('admin.index')->with('message', [
            'type' => 'alert-success',
            'content' => 'success delete book'
        ]);
    }
}

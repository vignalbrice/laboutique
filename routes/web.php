<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontController@showAllProducts')->name('home'); // route front vers tout les produits
Route::get('product/{id}', 'FrontController@showProductsById')->where(['id' => '[0-9]+'])->name('show_product'); // route front vers un produit par id
Route::get('category/{id}', 'FrontController@showProductsByCategory')->where(['id' => '[0-9]+'])->name('show_product_category'); // route front vers un produit par catégorie id
Route::get('codes/soldes', 'FrontController@showProductsBySoldes')->name('show_solde'); // route front vers les produits soldés
Route::resource('admin', 'BackController')->middleware('auth'); // route vers l'interface admin
Auth::routes(); // route vers l'interface d'authentification

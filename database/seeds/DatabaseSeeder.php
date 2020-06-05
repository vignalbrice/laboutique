<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{

    public function __construct(Faker\Generator $faker)
    {
        $this->faker = $faker;
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // insertion de l'utilisateur admin pour l'interface admin
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin')
            ],
        ]);
        // insertion des catégories hommes/femmes
        DB::table('categories')->insert([
            [
                'title' => 'Homme',
                'description' => 'La mode pour les hommes'
            ], [
                'title' => 'Femme',
                'description' => 'La mode pour les femmes'
            ]
        ]);
        // suppression de tout les fichiers existants dans le répertoire public/images
        Storage::disk('local')->delete(Storage::allFiles());
        // Ajout des produits via faker dans la table product
        factory(App\Product::class, 30)->create()->each(function ($product) {
            // Ajout du tableau des catégories
            $categories = ['Homme', 'Femme'];
            // Ajout des images dans storages et insertion des iamges dans le dossier public/images hommes pour la catégorie homme et femmes pour la catégorie femmes
            $femmes = Storage::disk('faker_images')->files('femmes');
            $hommes = Storage::disk('faker_images')->files('hommes');
            $genre = $this->faker->randomElement(['Homme', 'Femme']);
            if ($genre == 'Femme') {
                $file = $this->faker->randomElement($femmes);
                $file = Storage::disk('faker_images')->get($file);
                $link = Str::random(40) . '.jpg';
                Storage::put('femmes/' . $link, $file);
                $product->url_image = $link;
                $product->genre = 'Femme';
                $category = App\Category::where('title', $categories[1])->first();
                $product->category()->associate($category);
            }
            if ($genre == 'Homme') {
                $file = $this->faker->randomElement($hommes);
                $file = Storage::disk('faker_images')->get($file);
                $link = Str::random(40) . '.jpg';
                Storage::put('hommes/' . $link, $file);
                $product->url_image = $link;
                $product->genre = 'Homme';
                $category = App\Category::where('title', $categories[0])->first();
                $product->category()->associate($category);
            }
            $product->save();
        });
    }
}

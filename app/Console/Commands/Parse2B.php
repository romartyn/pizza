<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ingredient;
use App\Category;
use App\Product;
use App\Image;
use App\ProductIngredient;
use App\ProductCategory;
use Str;

class Parse2B extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:2b';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the dummy data from https://2-berega.ru/pizza';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('pcre.backtrack_limit', '104857600');
        $html = file_get_contents('storage/app/public/2b.html');
        preg_match_all("#<script.*REDUX_STATE=(.*)</script>#Uis", $html, $matches);
        $REDUX_STATE = json_decode($matches[1][0]);
        // print_r(array_keys((array)$REDUX_STATE));return;

        Ingredient::truncate();
        foreach ($REDUX_STATE->ingredients as $key => $ingredient) {
            // print_r($ingredient);
            \DB::table('ingredients')->insert([
                'id' => $ingredient->id,
                'title' => $ingredient->title
            ]);
            // return;
        }

        Category::truncate();
        foreach ($REDUX_STATE->categories as $key => $category) {
            // print_r($category);
            \DB::table('categories')->insert([
                'id' => $category->id,
                'title' => $category->title,
                'parent_id' => $category->parentId,
                'sort' => $category->sort,
                'description' => $category->description,
            ]);

            foreach ($category->images as $key => $image_http_src) {
                $this->saveImage($image_http_src, $category->id, Category::class, 'image');
            }

            if($category->menuImage){
                $this->saveImage($category->menuImage->url, $category->id, Category::class, 'menu');
            }
            // return;
        }

        Product::truncate();
        ProductIngredient::truncate();
        ProductCategory::truncate();
        foreach ($REDUX_STATE->products as $key => $product) {
            //print_r($product);//return;

            \DB::table('products')->insert([
                'id' => $product->id,
                'title' => $product->title,
                'weight' => Str::slug($product->title),
                'description' => $product->description,
                'seo_description' => $product->seoDescription,
                'short_description' => $product->shortDescription,
                'price' => $product->price,
                'base_price' => $product->basePrice,
                'unit_price' => $product->costPerUnit,
                'base_category' => $product->baseCategory ?? null,
                'weight' => $product->weight,
                'sort' => $product->sort,
            ]);

            foreach ($product->images as $key => $image_http_src) {
                $this->saveImage($image_http_src, $product->id, Product::class, 'image');
            }
            foreach ($product->ingredients as $key => $ingredient_id) {
                \DB::table('product_ingredients')->insert([
                    'product_id' => $product->id,
                    'ingredient_id' => $ingredient_id,
                ]);
            }
            foreach ($product->fullCategories as $key => $category_id) {
                \DB::table('product_categories')->insert([
                    'product_id' => $product->id,
                    'category_id' => $category_id,
                ]);
            }
            // return;
        }

        return 0;
    }

    private function saveImage($image_http_src, $imageable_id, $imageable_type, $type = 'image'){
        $parts = explode('/', $image_http_src);
        $fileName = array_pop($parts);
        $path =  $type . '/' . $fileName;
        $fileContent = file_get_contents($image_http_src);

        if($this->disk()->exists($path)){
            return Image::query()->where('src', $path)->first();
        }

        if ($this->disk()->put($path, $fileContent)) {

            $image = Image::query()->create([
                "imageable_type" => $imageable_type,
                "imageable_id" => $imageable_id,
                "src" => $path,
                "type" => $type,
            ]);

            return $image;
        }
    }

    private $disk = null;
    private function disk(){
        $this->disk = $this->disk ?? \Storage::disk('public');
        return $this->disk;
    }
}

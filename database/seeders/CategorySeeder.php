<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $n = "Categoría 1";
        $c = Category::create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/1.jpg',
        ]);

        $n = "Subcategoría 1";
        $c->children()->create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/2.jpg',
        ]);

        $n = "Subcategoría 2";
        $c->children()->create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/3.jpg',
        ]);

        $n = "Categoría 2";
        $c = Category::create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/2.jpg',
        ]);

        $n = "Subcategoría 3";
        $c->children()->create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/2.jpg',
        ]);

        $n = "Subcategoría 4";
        $c->children()->create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/3.jpg',
        ]);

        $n = "Categoría 3";
        $c = Category::create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/3.jpg',
        ]);

        $n = "Subcategoría 5";
        $c->children()->create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/2.jpg',
        ]);

        $n = "Subcategoría 6";
        $c->children()->create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/3.jpg',
        ]);

        $n = "Categoría 4";
        $c = Category::create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/4.jpg',
        ]);

        $n = "Subcategoría 7";
        $c->children()->create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/2.jpg',
        ]);

        $n = "Subcategoría 8";
        $c->children()->create([
            'name' => $n,
            'slug' => Str::slug($n),
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            'image' => 'categories/4.jpg',
        ]);
    }
}

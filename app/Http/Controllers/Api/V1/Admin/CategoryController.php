<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!request()->user()->tokenCan('category:access'), 403, '403 Forbidden');

        $searchTerm = $request->search ?? "";
        $size = $request->size ?? 10;

        $categories = Category::whereLike(['name','slug'], $searchTerm)
            ->orderBy('id', 'DESC')
            ->where('parent_id', null)
            ->paginate($size);
        return response()->json([
            'categories' => $categories->items(),
            'pagination' => [
                'total' => $categories->total(),
                'current_page' => $categories->currentPage(),
                'per_page' => $categories->perPage(),
                'last_page' => $categories->lastPage(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem()
            ]
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        abort_if(!request()->user()->tokenCan('category:create'), 403, '403 Forbidden');

        $data = $request->validate([
            'name' => 'required|unique:categories,name',
            'slug' => 'required|unique:categories,slug',
            'description' => 'required',
            'image' => 'required'
        ]);

        $filename_image = $request->image->store('categories', 'public');
        $img = Image::make("storage/{$filename_image}")->resize(640, 480);
        $img->save();

        $data["image"] = $filename_image;

        Category::create($data);

        return response()->json(['message' => '¡Categoría registrada con éxito!'], 201);

    }

    public function show($id)
    {
        abort_if(!request()->user()->tokenCan('category:show'), 403, '403 Forbidden');
        $category = Category::with('children:id,name,parent_id')
            ->findOrFail($id);
        return response()->json(['category' => $category]);
    }

    public function edit($id)
    {
        abort_if(!request()->user()->tokenCan('category:edit'), 403, '403 Forbidden');
        $category = Category::findOrFail($id);
        return response()->json(['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!request()->user()->tokenCan('slider:edit'), 403, '403 Forbidden');

        $data = $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
            'slug' => 'required|unique:categories,slug,' . $id,
            'description' => 'required'
        ]);

        if (isset($request->image) && $request->image != 'null') {

            if (File::exists('storage/' . $request->current_image)) {
                File::delete('storage/' . $request->current_image);
            }

            $filename_image = $request->image->store('categories', 'public');

            $img = Image::make("storage/{$filename_image}")->resize(640, 480);
            $img->save();

        } else {
            $filename_image = $request->current_image;
        }

        $data["image"] = $filename_image;

        Category::findOrFail($id)->update($data);

        return response()->json(['message' => '¡Registro actualizado con éxito!'], 202);
    }

    public function destroy($id)
    {
        abort_if(!request()->user()->tokenCan('category:delete'), 403, '403 Forbidden');

        $category = Category::findOrFail($id);

        $image = $category->image;
        $offer_image = $category->image;

        $category->delete();

        if (File::exists('storage/' . $image)) {
            File::delete('storage/' . $image);
        }

        if (File::exists('storage/' . $offer_image)) {
            File::delete('storage/' . $offer_image);
        }

        return response()->json('¡El registro ha sido eliminado con éxito!', 204);
    }

    public function changeStatus(Request $request)
    {
        abort_if(!request()->user()->tokenCan('category:change_status'), 403, '403 Forbidden');

        $id = $request->id;
        $status = $request->status;

        Category::findOrFail($id)->update(['status' => $status]);

        return response()->json('¡El estado se cambió correctamente!', 202);
    }

    public function changeFeatured(Request $request)
    {
        abort_if(!request()->user()->tokenCan('category:change_featured'), 403, '403 Forbidden');

        $id = $request->id;
        $featured = $request->featured;

        Category::findOrFail($id)->update(['featured' => $featured]);

        return response()->json('¡El estado de destacado se cambió correctamente!', 202);

    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }

    public function offer($id)
    {
        abort_if(!request()->user()->tokenCan('category:offer_management'), 403, '403 Forbidden');
        $category = Category::findOrFail($id);
        return response()->json(['category' => $category]);
    }

    public function setOffer(Request $request, $id)
    {
        abort_if(!request()->user()->tokenCan('category:offer_management'), 403, '403 Forbidden');

        $data = $request->validate([
            'offer_price' => 'required',
            'offer_discount' => 'required',
            'end_offer' => 'required'
        ]);

        if (isset($request->offer_image) && $request->offer_image != 'null') {

            if (File::exists('storage/' . $request->old_offer_image)) {
                File::delete('storage/' . $request->old_offer_image);
            }

            $filename_offer_image = $request->offer_image->store('offers', 'public');
            #Cambiamos el tamaño de la imagen
            $img = Image::make("storage/{$filename_offer_image}")->resize(640, 480);
            $img->save();

        } else {
            $filename_offer_image = $request->old_offer_image;
        }

        $data["offer_image"] = $filename_offer_image;
        $data["is_offer"] = 1;

        //Actualizamos los datos de oferta de la categoria
        Category::findOrFail($id)->update($data);

        //Establecemos oferta a todas las subcategorias
        $data["is_offer_by_category"] = 1;
        Category::where('parent_id', $id)->update($data);

        //Establecemos la oferta en todos los productos que pertenecen a las subcategorias
        $category = Category::findOrFail($id);

        $offer_price = $data["offer_price"];
        $offer_discount = $data["offer_discount"];

        foreach ($category->children as $sub) {

            $products = $sub->products;

            foreach ($products as $value) {

                if ($offer_price == 0) {

                    $offer_price_update = $value->price - ($value->price * $offer_discount / 100);
                    $offer_discount_update = $offer_discount;

                } elseif ($offer_discount == 0) {

                    $offer_price_update = $offer_price;
                    $offer_discount_update = 100 - ($offer_price * 100 / $value->price);

                } else {

                    $offer_price_update = 0;
                    $offer_discount_update = 0;
                }

                $data["offer_price"] = $offer_price_update;
                $data["offer_discount"] = $offer_discount_update;
                $data["is_offer_by_category"] = 1;

                Product::where('id', $value->id)
                    ->where('category_id', $sub->id)->update($data);

            }

        }

        return response()->json(['message' => '¡La oferta ha sido aplicada con éxito!'], 202);

    }

    public function deactivateOffer($id)
    {
        abort_if(!request()->user()->tokenCan('category:offer_management'), 403, '403 Forbidden');

        $category = Category::findOrFail($id);

        $offer_image = $category->offer_image;

        #Eliminamos la imagen de oferta
        if (File::exists('storage/' . $offer_image)) {
            File::delete('storage/' . $offer_image);
        }

        $data = [
            'is_offer' => 0,
            'is_offer_by_category' => 0,
            'offer_price' => 0,
            'offer_discount' => 0,
            'end_offer' => null,
            'offer_image' => null,
        ];

        $category->update($data);

        //Removemos la oferta de las subcategorias
        Category::where('parent_id', $id)->update($data);

        //removemos la oferta de los productos

        foreach ($category->children as $sub) {

            Product::where('category_id', $sub->id)->update($data);

        }

        return response()->json(['message' => '¡La oferta ha sido removida con éxito!'], 202);

    }

}

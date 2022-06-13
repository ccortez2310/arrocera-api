<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\SliderStatus;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!request()->user()->tokenCan('slider:access'), 403, '403 Forbidden');

        $searchTerm = $request->search ?? "";
        $size = $request->size ?? 10;

        $sliders = Slider::whereLike(['title'], $searchTerm)
            ->orderBy('id', 'DESC')
            ->paginate($size);
        return response()->json([
            'sliders' => $sliders->items(),
            'pagination' => [
                'total' => $sliders->total(),
                'current_page' => $sliders->currentPage(),
                'per_page' => $sliders->perPage(),
                'last_page' => $sliders->lastPage(),
                'from' => $sliders->firstItem(),
                'to' => $sliders->lastItem()
            ]
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        abort_if(!request()->user()->tokenCan('slider:create'), 403, '403 Forbidden');

        $data = $request->validate([
            'title' => 'required',
            'main_image' => 'required',
            'responsive_image' => 'required'
        ]);

        $filename_image = $request->main_image->store('sliders', 'public');
        $img = Image::make("storage/{$filename_image}")->resize(1600, 520);
        $img->save();

        $filename_responsive_image = $request->responsive_image->store('sliders', 'public');
        $img2 = Image::make("storage/{$filename_responsive_image}")->resize(640, 640);
        $img2->save();

        $data["main_image"] = $filename_image;
        $data["responsive_image"] = $filename_responsive_image;
        $data["status"] = SliderStatus::ACTIVE;

        Slider::create($data);

        return response()->json(['message' => '¡Slider registrado con éxito!'], 201);

    }

    public function show($id)
    {
        abort_if(!request()->user()->tokenCan('slider:show'), 403, '403 Forbidden');
        $slider = Slider::findOrFail($id);
        return response()->json(['slider' => $slider]);
    }

    public function edit($id)
    {
        abort_if(!request()->user()->tokenCan('slider:edit'), 403, '403 Forbidden');
        $slider = Slider::findOrFail($id);
        return response()->json(['slider' => $slider]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!request()->user()->tokenCan('slider:edit'), 403, '403 Forbidden');

        $data = $request->validate([
            'title' => 'required'
        ]);

        if (isset($request->main_image) && $request->main_image != 'null') {

            if (File::exists('storage/' . $request->current_main_image)) {
                File::delete('storage/' . $request->current_main_image);
            }

            $filename_image = $request->main_image->store('sliders', 'public');

            $img = Image::make("storage/{$filename_image}")->resize(1600, 520);
            $img->save();

        } else {
            $filename_image = $request->current_main_image;
        }

        if (isset($request->responsive_image) && $request->responsive_image != 'null') {

            if (File::exists('storage/' . $request->current_responsive_image)) {
                File::delete('storage/' . $request->current_responsive_image);
            }

            $filename_responsive_image = $request->responsive_image->store('sliders', 'public');

            $img2 = Image::make("storage/{$filename_responsive_image}")->resize(640, 640);
            $img2->save();

        } else {
            $filename_responsive_image = $request->current_responsive_image;
        }

        $data["main_image"] = $filename_image;
        $data["responsive_image"] = $filename_responsive_image;

        Slider::find($id)->update($data);

        return response()->json(['message' => '¡Registro actualizado con éxito!'], 202);
    }

    public function destroy($id)
    {
        abort_if(!request()->user()->tokenCan('slider:delete'), 403, '403 Forbidden');

        $slider = Slider::findOrFail($id);

        if (File::exists('storage/' . $slider->main_image)) {
            File::delete('storage/' . $slider->main_image);
        }

        if (File::exists('storage/' . $slider->responsive_image)) {
            File::delete('storage/' . $slider->responsive_image);
        }

        $slider->delete();

        return response()->json('¡El registro ha sido eliminado con éxito!', 204);
    }

    public function changeStatus(Request $request)
    {
        abort_if(!request()->user()->tokenCan('slider:change_status'), 403, '403 Forbidden');

        $id = $request->id;
        $status = $request->status;

        Slider::findOrFail($id)->update(['status' => $status]);

        return response()->json('¡El estado se cambió correctamente!', 202);

    }
}

<?php

use App\Http\Controllers\Api\V1\Admin\AbilityController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\SliderController;
use App\Http\Controllers\Api\V1\Auth\Admin\AuthController;
use App\Http\Controllers\Api\V1\Auth\Admin\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    Route::post('login', [AuthController::class, 'login']);

    Route::post('forgot-password', [ResetPasswordController::class, 'forgotPassword']);
    Route::post('reset-password', [ResetPasswordController::class, 'reset']);

});


//Routes for main site
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'v1'], function () {

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::post('logout', [AuthController::class, 'logout']);

    //Abilities
    Route::apiResource('abilities', AbilityController::class, ['only' => 'index']);

    //Slider
    Route::post('sliders/change-status', [SliderController::class, 'changeStatus']);
    Route::resource('sliders', SliderController::class);

    //Categories
    Route::get('categories/check-slug', [CategoryController::class, 'checkSlug']);
    Route::post('categories/change-status', [CategoryController::class, 'changeStatus']);
    Route::post('categories/change-featured', [CategoryController::class, 'changeFeatured']);
    Route::put('categories/deactivate-offer/{id}', [CategoryController::class, 'deactivateOffer']);
    Route::get('categories/{id}/offer', [CategoryController::class, 'offer']);
    Route::put('categories/offer/{id}', [CategoryController::class, 'setOffer']);
    Route::resource('categories', CategoryController::class);


});

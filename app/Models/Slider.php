<?php

namespace App\Models;

use App\Enums\SliderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'main_image',
        'responsive_image',
        'status'
    ];


    protected $casts = [
        'status' => SliderStatus::class
    ];

}

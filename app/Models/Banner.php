<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getBanners() {
        $getBanners = Banner::where('status', 1)->get();
        return $getBanners;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function section(){
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function attributes(){
        return $this->hasMany(ProductAttribute::class);
    }

    public function images(){
        return $this->hasMany(ProductImages::class);
    }

    public static function productFilters(){
        $productFilters['fabricArray'] = ["Cotton", "Polyester", "Wool"];
        $productFilters['sleeveArray'] = ["Full Sleeve", "Half Sleeve", "Short Sleeve", "Sleeveless"];
        $productFilters['patternArray'] = ["Checked", "Plain", "Printed", "Self", "Solid"];
        $productFilters['fitArray'] = ["Regular", "Slim"];
        $productFilters['occasionArray'] = ["Casual", "Formal"];
        return $productFilters;
    }

}

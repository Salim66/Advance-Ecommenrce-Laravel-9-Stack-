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

    public function attributes(){
        return $this->hasMany(ProductAttribute::class);
    }

}

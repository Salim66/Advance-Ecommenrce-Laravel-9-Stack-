<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function section(){
        $get_sections = Section::with('categories')->where('status', 1)->get();
        return $get_sections;
    }

    public function categories(){
        return $this->hasMany(Category::class, 'section_id')->where(['parent_id' => 'ROOT', 'status' => 1])->with('subCategories');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subCategories(){
        return $this->hasMany(Category::class, 'parent_id')->where('status', 1);
    }

    public function parentCategory(){
        return $this->belongsTo(Category::class, 'parent_id')->select('id','category_name');
    }

    public function section(){
        return $this->belongsTo(Section::class, 'section_id')->select('id','name');
    }

    /**
     * Category Detalis find
     */
    public static function categoryDetails($url){
        $categoryDetails = Category::select('id', 'parent_id', 'category_name', 'url', 'description')->with(['subCategories' => function($query){
            $query->select('id','parent_id', 'category_name', 'url', 'description')->where('status', 1);
        }])->where('url', $url)->first()->toArray();
        $categories = Category::with('subCategories')->where('url', $url)->first();
        // return $categories;
        if($categoryDetails['parent_id'] == 0){
            $breadcrumbs = '<a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';
        }else {
            $parentCategory = Category::select('category_name', 'url')->where('id', $categoryDetails['parent_id'])->first()->toArray();
            $breadcrumbs = '<a href="'.url($parentCategory['url']).'">'.$parentCategory['category_name'].'</a>&nbsp;<span class="divider">/</span>&nbsp;<a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';
        }
        $catIds = [];
        $catIds[] = $categoryDetails['id'];
        foreach ($categories->subCategories as $key => $subcat) {
            $catIds[] = $subcat->id;
        }
        return ['catIds'=>$catIds, 'categoryDetails'=>$categoryDetails, 'breadcrumbs'=>$breadcrumbs];
    }

}

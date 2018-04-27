<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
       //每个分类下的话题展示30条
       $topics = Topic::where('category_id',$category->id)->with('user','category')->paginate(30);
       return view('topics.index',compact('topics','category'));
    }
}

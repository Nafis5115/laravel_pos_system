<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    function CategoryPage() {
        return view('pages.dashboard.category-page');
    }

    function categoryList(Request $request) {
        $user_id = $request->header('id');
        return Category::where('user_id', $user_id)->get();
    }

    function createCategory(Request $request) {
        $user_id = $request->header('id');
        return Category::create([
            'name'    => $request->name,
            'user_id' => $user_id,
        ]);
    }

    function categoryByID(Request $request) {
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return Category::where('id', $category_id)->where('user_id', $user_id)->first();
    }

    function deleteCategory(Request $request) {
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return Category::where('id', $category_id)->where('user_id', $user_id)->delete();
    }

    function updateCategory(Request $request) {
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return Category::where('id', $category_id)->where('user_id', $user_id)->update([
            'name' => $request->name,
        ]);
    }

}

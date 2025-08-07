<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ProductController extends Controller {

    function ProductPage(): View {
        return view('pages.dashboard.product-page');
    }

    function createProduct(Request $request) {
        $user_id = $request->header('id');
        $img = $request->file('img');

        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}-{$t}-{$file_name}";
        $img_url = "uploads/{$img_name}";
        $img->move(public_path('uploads'), $img_name);

        return Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'unit'        => $request->unit,
            'img_url'     => $img_url,
            'category_id' => $request->category_id,
            'user_id'     => $user_id,
        ]);
    }

    function deleteProduct(Request $request) {
        $user_id = $request->header('id');
        $product_id = $request->id;
        $file_path = $request->file_path;
        File::delete($file_path);
        return Product::where('id', $product_id)->where('user_id', $user_id)->delete();
    }

    function productByID(Request $request) {
        $user_id = $request->header('id');
        $product_id = $request->id;
        return Product::where('id', $product_id)->where('user_id', $user_id)->first();

    }

    function productList(Request $request) {
        $user_id = $request->header('id');
        return Product::where('user_id', $user_id)->get();
    }

    function updateProduct(Request $request) {
        $user_id = $request->header('id');
        $product_id = $request->input('id');

        if ($request->hasFile('img')) {

            // Upload New File
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/{$img_name}";
            $img->move(public_path('uploads'), $img_name);

            // Delete Old File
            $filePath = $request->input('file_path');
            File::delete($filePath);

            // Update Product

            return Product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name'        => $request->input('name'),
                'price'       => $request->input('price'),
                'unit'        => $request->input('unit'),
                'img_url'     => $img_url,
                'category_id' => $request->input('category_id'),
            ]);

        } else {
            return Product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name'        => $request->input('name'),
                'price'       => $request->input('price'),
                'unit'        => $request->input('unit'),
                'category_id' => $request->input('category_id'),
            ]);
        }
    }
}

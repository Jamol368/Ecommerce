<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $main_category = MainCategory::take(5)->get();
        $products = Product::take(8)->get();
        return view('welcome', ['data' => $main_category, 'products' => $products]);
    }

    public function view(Request $request)
    {
        $product = Product::find($request->id);
        $products = Product::where('main_category_id', $product->main_category_id)->take(4)->get();
        return view('product', ['product' => $product, 'products' => $products]);
    }

    public function category(Request $request)
    {
        $main_category = MainCategory::find($request->id);
        $products = Product::where('main_category_id', $main_category->id)->paginate(15);
        return view('category', ['main_category' => $main_category, 'products' => $products]);
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%'.$request->search.'%')->paginate(15);
        return view('search', ['products' => $products]);
    }
}

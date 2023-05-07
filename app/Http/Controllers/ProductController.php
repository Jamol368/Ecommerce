<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Displays product's
     *
     * @return mixed
     */
    public function index()
    {
        $main_category = Category::where('parent_id', null)->take(5)->get();
        $products = Product::take(8)->get();
        return view('welcome', ['data' => $main_category, 'products' => $products]);
    }

    /**
     * Displays product details
     *
     * @param Request $request
     * @return mixed
     */
    public function view(Request $request)
    {
        $product = Product::find($request->id);
        $products = Product::whereHas('categories.products', function ($q) use ($product) {
            $q->where('product_id', $product->id);
        })->take(4)->get();
        return view('product', ['product' => $product, 'products' => $products]);
    }

    /**
     * Displays category related products
     *
     * @param Request $request
     * @return mixed
     */
    public function category(Request $request)
    {
        $main_category = Category::find($request->id);
        $products = Product::whereHas('categories.products', function ($q) use ($main_category) {
            $q->where('category_id', $main_category->id);
        })->paginate(15);
        return view('category', ['main_category' => $main_category, 'products' => $products]);
    }

    /**
     * Displays search result from products
     *
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->search . '%')->paginate(15);
        return view('search', ['products' => $products]);
    }
}

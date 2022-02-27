<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::get();
        return view('home', compact('categories'));
    }

    public function category ($category)
    {
        return view('category', compact('category'));
    }
    
    public function getProducts (Category $category) 
    {
        $products = $category->products;
        $products->transform(function($product) {
            $product->quantity = session("cart.{$product->id}") ?? 0;
            return $product;
        }); 
        return $products;
    }
}
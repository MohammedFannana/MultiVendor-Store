<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // with('category') to relationship use beacuse i use relation in front.home =>in product
        $products = Product::with('category')->where('status', '=', 'active')->latest()->limit(8)->get();
        return view('front.home', compact('products'));
    }
}

<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // to select all product and filter
    public function index()
    {
    }

    // to offer detailes of product
    public function show(Product $product)
    {

        // for more security
        if ($product->status != 'active') {
            abort(404);
        }

        return view('front.products.show', compact('product'));
    }
}

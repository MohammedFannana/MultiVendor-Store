<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = new CartModelRepository();
        // send object
        return view('front.cart', [
            'items' => $cart,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity'   => ['nullable', 'int', 'min:1'],
        ]);

        $product = Product::findOrFail($request->post('product_id'));

        $repository = new CartModelRepository();
        $repository->add($product, $request->post('quantity'));


        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity'   => ['required', 'int', 'min:1'],
        ]);

        $product = Product::findOrFail($request->post('product_id'));

        //CartModelRepository file in App
        $repository = new CartModelRepository();
        $repository->update($id, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $repository = new CartModelRepository();
        $repository->delete($id);
    }
}

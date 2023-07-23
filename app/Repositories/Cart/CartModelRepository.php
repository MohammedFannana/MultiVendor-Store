<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Spatie\LaravelIgnition\Support\FlareLogHandler;

class CartModelRepository implements CartRepository
{
    public function get(): Collection
    {
        // use with beacuse relation with product video 10.1  1:18:00
        return Cart::with('product')->where('cookie_id', '=', $this->getCookieID())->get();
    }

    public function add(Product $product, $quantity = 1)
    {
        // Check if item is define to not insert the same item more one 
        //and only update quantity
        $item = Cart::where('product_id', '=', $product->id)
            ->where('cookie_id', '=', $this->getCookieID())->first();

        if (!$item) {
            $cart =  Cart::create([
                // id is create use event in model
                'cookie_id' => $this->getCookieID(),
                'user_id'   => Auth()->user()->id,
                'product_id' => $product->id,
                'quantity'  => $quantity,

            ]);
            return $cart;
        }

        // add quantity value $quantity
        return $item->increment('quantity', $quantity);
    }

    public function update($id, $quantity)
    {
        Cart::where('id', '=', $id)
            ->where('cookie_id', '=', $this->getCookieID())
            ->update([
                'quantity' => $quantity,
            ]);
    }

    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->where('cookie_id', '=', $this->getCookieID())
            ->delete();
    }

    public function empty()
    {
        Cart::where('cookie_id', '=', $this->getCookieID())->delete();
    }

    public function total(): float
    {
        return (float) Cart::where('cookie_id', '=', $this->getCookieId())
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')->value('total');
        //use selectRaw beacuse use SUM 
        // value to return value only (not use get or first return object)
        // use value to return value 
    }


    //This function to slove cookie_id problem
    protected function getCookieID()
    {
        // the value is get iam name 'cart_id'
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            //store cookie $cookie_id
            //store yo 30day
            Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
        }
        return $cookie_id;
    }
}

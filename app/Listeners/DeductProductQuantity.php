<?php

namespace App\Listeners;

use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($order)
    {
        // products relationship function

        // foreach ($order->products as $product) {
        //     $product->decrement($product->pivot->quantity);
        // }

        try {
            foreach (Cart::get() as $item) {
                //with not $order handle()
                Product::where('id', '=', $item->product_id)->update([
                    'quantity' => DB::raw("quantity - {$item->quantity}")
                ]);
            }
        } catch (Throwable $e) {
        }
    }
}

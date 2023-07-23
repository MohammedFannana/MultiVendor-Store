<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Tag;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //need to return this in all this page to congirm select prouducts linke in define store 
        //you can use global scope like lesson 18
        $user = Auth::user();
        if ($user->store_id) {
            //to uplode relationship connection with Products  with([functionName in product models]) with([])->
            // provide use with([]) in relation ship if use relation more one
            $products = Product::where('store_id', '=', $user->store_id)->with(['category', 'store'])->paginate();
        } else {

            $products = Product::with(['category', 'store'])->paginate();
        }
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        //select tag to product use relation to offer
        // tags => collection for all model i need only name use pluke
        // pluke use if you want define thing from realtion
        //i need only name form relation
        // function in product model
        //tags = colloction object
        //tags() = like array if need define thing from relation
        //pluks() => if you define column from relation  return name as object
        //toArray() => to translate object to array
        //implode() => to translate array to string ',' => للفصل بين العناصر
        $tags = implode(',', $product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->except('tags'));

        //explode => function in php turn to arrary ,
        //من عند الفاصلة حيبدأ يقسم ويخزن في المصفوفة
        //tags procees in video 21
        // $tags = explode(',', $request->post('tags'));

        //because use library to tagfiy send array and object contine value $t_name->value
        $tags = json_decode($request->post('tags'));

        //to product_tag table
        $tag_ids = [];

        $saved_tags = Tag::all();

        foreach ($tags as $t_name) {
            $slug = Str::slug($t_name->value);
            // if want to search in collection like $saved_tags  use ->where 
            // in database query statment use ::where
            $tag = $saved_tags->where('slug', $slug)->first();

            if (!$tag) {
                $tag = Tag::create([
                    'name' => $t_name->value,
                    'slug' => $slug,
                ]);
            }

            $tag_ids[] = $tag->id;
        }

        //use relation between product and tag 
        // tags() function in product model
        //sync use only many to many delete and insert
        $product->tags()->sync($tag_ids);


        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product Update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

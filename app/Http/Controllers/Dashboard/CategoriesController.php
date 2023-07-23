<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Exceptions\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Exists;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Start Filter Search
        $request = request();  //= index(Request $request)

        // Select * FROM categories as a
        //Inner Join categories as b ON b.id =a .parent_id

        $query = Category::query();

        if ($name = $request->query('name')) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        if ($status = $request->query('status')) {
            $query->where('status', '=', $status);
        }

        // End Filter Search

        // $categories = Category::paginate(2); //Return Collection object handle like Array
        //Edit because Filter
        //use left join not join beacuse not all use parent id
        $categories = $query
            ->leftjoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select(['categories.*', 'parents.name as parent_name'])
            // if insert more one select use add
            /////////to get count without relation
            // ->addselect('categories.*')
            // ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count')

            /////to get count use Relationship ('function relation name in categot model')
            ->withCount('products')
            ->orderBy('name')
            //->withTrashed() //to show soft delete categories
            ->paginate();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        return view('dashboard.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->input('name');
        // $request->post('name');
        // $request->query('name');
        // $request->get('name');
        // $request->name;

        // $request->all();
        // $request->only('name');
        // $request->except('name');

        //you can use new Category(); and ->save()


        //////////validate very importent  function in category model
        $request->validate(Category::rules(), [
            'required' => 'This field (:attribute) is required',
            'unique' => 'This is name already exists!',  //to change message
        ]);



        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        //use this way because the image insert by user not insert in database but the path //video 10
        $data = $request->except('image');

        if ($request->hasFile('image')) {    //to check if image file is exit
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');  //store image in public disk insde storge folder inside uploads folder ,'public' or['disk' => 'public]

            $data['image'] = $path;
        }



        $category = Category::create($data);
        //you can use this way if the name of input in form equal the colmun in database

        //in store process you must follow in redirct()
        //prg
        return redirect()->route('dashboard.categories.index')->with('success', 'The Category Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        ////////SELECT * FROM categories WHERE id <> $id
        // AND ($parent_id IS NULL OR $parent_id <> $id)
        //الاقواس بنعملها فنكشن زي الجروب 
        $parents  = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {          //like group like() //to $id inside the function  use global not excellent but use use()
                $query->whereNull('parent_id')
                    ->orwhere('parent_id', '<>', $id);
            })->get();

        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(Category::rules($id));


        //like the store function 70%
        $category = Category::findOrFail($id);

        //******** to handle with error as you want
        // try {
        //     $category = Category::findOrFail($id);
        // } catch (Exception $e) {
        //     return redirect()->route('dashboard.categories.index')->with('info', 'The Category not found!');
        // }

        $old_image = $category->image;

        $data = $request->except('image');

        if ($request->hasFile('image')) {    //to check if image file is exit
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');  //store image in public disk insde storge folder inside uploads folder ,'public' or['disk' => 'public]

            $data['image'] = $path;
        }

        $category->update($data);

        if ($old_image && isset($data['image'])) {
            Storage::disk('public')->delete($old_image);
        }

        // use $request->all() if the name in form same the name of column in database
        // $category->update([
        //     'name' => $request->name,
        // ]);

        return redirect()->route('dashboard.categories.index')->with('success', 'The Category Update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        // stop because use soft delete move to force delete
        // if ($category->image) {
        //     Storage::disk('public')->delete($category->image);
        // }

        // Category::destroy($id);
        // Category::where('id', '=', $id)->delete();

        return redirect()->route('dashboard.categories.index')->with('success', 'The Category Delete!');
    }


    public function trash()
    {
        //onlyTrashed to show only softDelete category
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, string $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')->with('success', 'Category restored!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        //not need image in force delete
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')->with('success', 'Category deleted forever!');
    }
}

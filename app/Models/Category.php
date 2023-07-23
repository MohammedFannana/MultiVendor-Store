<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use App\Rules\filter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name', 'parent_id', 'description', 'image', 'status', 'slug'
    ];

    //one to many relation brtween categoru and products

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    //inverse the fillable
    //protected $guarded = [];


    //validation function 

    public static function rules($id = 0)
    {
        // unique:tabel,column,except the my id update عشان لما اعمل تحديث ما يقلي الحقل موجود وهوالحقل ملكه
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                //unique:categories,name,$id", or
                Rule::unique('categories', 'name')->ignore($id),

                //to bulid self validation $value = value inter in input , $failes = The error message
                //if you want to use this public you use the php atrisan make:rules rules_name

                function ($attribute, $value, $failes) {
                    if (strtolower($value) == 'laravel') {
                        $failes('This Name is forbidden!');
                    }
                }

                //the filter class in app folder استدعاء
                // new filter()
            ],

            //Or  exists the parent_id must found in categories.id
            'parent_id' => ['nullable', 'int', 'Exists:categories,id'],
            //in image you can use 'mimes :png,jpeg,....' max =>size بايت
            'image' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'status' => 'required|in:active,inactived' //choose bettween to value
        ];
    }
}

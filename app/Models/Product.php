<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;



class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'slug', 'description', 'image', 'category_id', 'store_id', 'price', 'compare_price', 'status',
    ];

    // return api hidden this column
    //hideen image beacuse appens image_url accessor in api 
    //to prevent use not true path
    protected $hidden = [
        'image', 'created_at', 'updated_at', 'deleted_at'
    ];

    // use appends Accessor in Api  // api use this Accessor
    protected $appends = [
        // image_url Accessor in product Model
        'image_url',
    ];


    // to create event 
    //this event if create product => create slug automatically in direct
    protected static function booted()
    {
        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }


    //relation with category

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    //relation with stores

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {

        //you can write only related modle
        // Tag اذا كنت ملتزم في تسمية لارافيل في اسماء الجداةل والحقول كما موضح مودل 
        return $this->belongsToMany(
            Tag::class,      //Related Model
            'product_tag',   //Pivot table name وسيط
            'product_id',    //FK in pivot table for the current model
            'tag_id',        //FK in pivot table for the related model
            'id',            //PK current table
            'id'             //PK related table
        );
    }

    //Accessors
    //define ImageUrl but invoke image_url
    //get....Attribute
    public function getImageUrlAttribute()
    {
        // column image in database
        if (!$this->image) {
            return "https://www.incathlab.com/images/products/default_product.png";
        }

        // if $this->image start with http:// or https://
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }


    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }

        return round(100 - (100 * $this->price / $this->compare_price), 1);
    }

    // this function from Api
    // use in controller Product in api folder
    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], function ($query, $status) {
            return $query->where('store_id', $status);
        });

        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });

        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });


        // tags is relationship name
        $builder->when($options['tag_id'], function ($builder, $value) {

            $builder->whereExists(function ($query) use ($value) {
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id', $value);
            });

            // $builder->whereHas('tags', function ($builder) use ($value) {
            //     $builder->whereIn('id', $value);
            // });
        });
    }
}

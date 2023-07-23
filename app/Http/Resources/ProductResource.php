<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // change response of the Api
        return [
            // $this return to product model
            'id' => $this->id,
            'name' => $this->name,
            'price' => [
                'normal' => $this->price,
                'compare' => $this->compare_price,
            ],
            'description' => $this->description,
            'image' => $this->image_url,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,

            ],

        ];
    }
}

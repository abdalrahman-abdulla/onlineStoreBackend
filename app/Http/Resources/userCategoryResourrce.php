<?php

namespace App\Http\Resources;
use App\Http\Resources\subcategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class userCategoryResourrce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'subCategory' => subcategoryResource::collection($this->subcategories)
        ];
    }
}

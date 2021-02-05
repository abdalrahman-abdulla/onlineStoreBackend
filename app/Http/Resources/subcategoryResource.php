<?php

namespace App\Http\Resources;
use App\category;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\categoryResource;


class subcategoryResource extends JsonResource
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
            'category' => new categoryResource(category::findOrFail($this->category_id)),
            'created_at' => $this->created_at

        ];
    }
}

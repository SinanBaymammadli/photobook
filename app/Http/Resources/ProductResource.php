<?php

namespace App\Http\Resources;

use App\Http\Resources\PhotoResource;
use App\Http\Resources\ProductType;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "details" => $this->details,
            "photos" => PhotoResource::collection($this->photos),
            "types" => ProductType::collection($this->types),
        ];
    }
}

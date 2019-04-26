<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total_photo_count = 0;

        foreach ($this->photos as $photo) {
            $total_photo_count += $photo->count;
        }

        return [
            'id' => $this->id,
            'ordered' => $this->ordered,
            'status' => [
                'name' => $this->status->display_name,
                'description' => $this->status->description,
            ],
            'photo_count' => $total_photo_count,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}

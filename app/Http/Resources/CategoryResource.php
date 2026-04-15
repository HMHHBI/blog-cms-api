<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->name, // Humne frontend ke liye naam 'title' rakh diya
            'link' => $this->slug,
            'info' => $this->description,
            // Hum created_at aur updated_at nahi bhej rahe, clean API!
        ];
    }
}

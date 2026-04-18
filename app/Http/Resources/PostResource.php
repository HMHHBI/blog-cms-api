<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'post_title' => $this->title,
            'url_slug' => $this->slug,
            'body' => $this->content,
            'image' => $this->image,
            'is_premium' => (bool) $this->is_premium,
            'published_at' => $this->created_at->format('d M Y'),
            // ✅ Category ka data clean karke bhej rahe hain
            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => $this->author->name ?? 'Unknown',
        ];
    }
}

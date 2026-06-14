<?php

namespace App\Http\Resources\Api\Blog\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Трансформація ресурсу в масив.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'is_published'   => (bool) $this->is_published,

            'date_published' => $this->published_at
                ? \Carbon\Carbon::parse($this->published_at)->format('Y-m-d H:i:s')
                : null,

            'user_id'        => $this->user_id,
            'category_id'    => $this->category_id,
        ];
    }
}

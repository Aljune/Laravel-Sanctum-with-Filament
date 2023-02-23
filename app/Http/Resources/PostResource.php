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
        // return parent::toArray($request);
        return [
            'id' => (string)$this->id,
            'attributes' => [
                'title' => $this->title,
                'category_id' => $this->category_id,
                'slug' => $this->slug,
                'content' => $this->content,
                'is_published' => $this->is_published,
                'order' => $this->order,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'relationship' => [
                'id' => (string)$this->user->id,
                'user name' => $this->user->name,
                'user email' => $this->user->email
            ]
        ];
    }
}

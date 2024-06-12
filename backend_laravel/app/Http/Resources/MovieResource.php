<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'origin_name' => $this->origin_name,
            'content' => $this->content,
            'type' => $this->type,
            'status' => $this->status,
            'poster_url' => $this->poster_url,
            'thumb_url' => $this->thumb_url,
            'is_copyright' => $this->is_copyright,
            'sub_docquyen' => $this->sub_docquyen,
            'chieurap' => $this->chieurap,
            'trailer_url' => $this->trailer_url,
            'time' => $this->time,
            'episode_current' => $this->episode_current,
            'episode_total' => $this->episode_total,
            'quality' => $this->quality,
            'lang' => $this->lang,
            'notify' => $this->notify,
            'showtimes' => $this->showtimes,
            'year' => $this->year,
            'view' => $this->view,
            'actor' => $this->actor,
            'director' => $this->director,
            'country_id' => $this->country_id,
            'category_id' => $this->category_id,
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

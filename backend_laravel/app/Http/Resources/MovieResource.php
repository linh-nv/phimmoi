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
            'type' => $this->type->name,
            'status' => $this->status->name,
            'poster_url' => $this->poster_url,
            'thumb_url' => $this->thumb_url,
            'is_copyright' => $this->is_copyright,
            'sub_docquyen' => $this->sub_docquyen,
            'chieurap' => $this->chieurap,
            'trailer_url' => $this->trailer_url,
            'time' => $this->time,
            'episode_current' => $this->episode_current,
            'episode_total' => $this->episode_total,
            'quality' => $this->quality->name,
            'lang' => $this->lang,
            'notify' => $this->notify,
            'showtimes' => $this->showtimes,
            'year' => $this->year,
            'view' => $this->view,
            'actor' => $this->actor,
            'director' => $this->director,
            'country' => CountryResource::make($this->whenLoaded('country')),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
            'episodes' => EpisodeResource::collection($this->whenLoaded('episodes')),
        ];
    }
}

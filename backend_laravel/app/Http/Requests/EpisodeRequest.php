<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EpisodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        $admin = Auth::guard('admin-api')->user();

        return $admin instanceof \App\Models\Admin;
    }

    public function rules(): array
    {
        $episodeId = $this->route('episode')?->$this->route('episode')->id;

        return [
            'name' => 'required|string|max:255',
            'movie_slug' => 'required|exists:movies,slug',

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('episodes', 'slug')
                    ->where('movie_slug', $this->movie_slug)
                    ->ignore($episodeId),
            ],
            'link_embed' => 'required|string|max:255',
        ];
    }


    public function messages(): array
    {

        return [
            'title.required' => 'The Title field is required.',
            'title.string' => 'The Title must be a string.',
            'title.max' => 'The Title may not be greater than 255 characters.',

            'movie_slug.required' => 'The movie slug field is required.',
            'movie_slug.exists' => 'The selected movie slug is invalid.',

            'slug.required' => 'The Slug field is required.',
            'slug.string' => 'The Slug must be a string.',
            'slug.max' => 'The Slug may not be greater than 255 characters.',
            'slug.unique' => 'The Slug has already been taken. Please choose a different Slug.',

            'link_embed.required' => 'The link_embed field is required.',
            'link_embed.string' => 'The link_embed must be a string.',
            'link_embed.max' => 'The link_embed may not be greater than 255 characters.',
        ];
    }
}

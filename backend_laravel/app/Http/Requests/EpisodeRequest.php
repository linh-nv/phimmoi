<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EpisodeRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        $episodeId = $this->route('episode') ? $this->route('episode')->id : null;

        return [
            'name' => 'required|string|max:255',
            'movie_id' => 'required|integer|exists:movies,id',

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($episodeId),
            ],
            'link_embed' => 'required|string|max:255',
        ];
    }


    public function messages()
    {

        return [
            'title.required' => 'The Title field is required.',
            'title.string' => 'The Title must be a string.',
            'title.max' => 'The Title may not be greater than 255 characters.',

            'movie_id.required' => 'The movie ID field is required.',
            'movie_id.integer' => 'The movie ID must be an integer.',
            'movie_id.exists' => 'The selected movie ID is invalid.',

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

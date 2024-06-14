<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        $movieId = $this->route('movie') ? $this->route('movie')->id : null;

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($movieId),
            ],
            'origin_name' => 'required|string|max:255',
            'content' => 'required',
            'type' => 'required|int|in:1,2,3',
            'status' => 'required|int|in:1,2',
            'poster_url' => 'required|string|max:255',
            'thumb_url' => 'required|string|max:255',
            'is_copyright' => 'required|bool',
            'sub_docquyen' => 'required|bool',
            'chieurap' => 'required|bool',
            'trailer_url' => 'string|max:255',
            'time' => 'string|max:255',
            'episode_current' => 'string|max:255',
            'episode_total' => 'int|max:10',
            'quality' => 'string|max:255',
            'lang' => 'string|max:255',
            'notify' => 'string|max:255',
            'showtimes' => 'string|max:255',
            'year' => 'int|max:4',
        ];
    }


    public function messages()
    {

        return [
            'title.required' => 'The Title field is required.',
            'title.string' => 'The Title must be a string.',
            'title.max' => 'The Title may not be greater than 255 characters.',
            'slug.required' => 'The Slug field is required.',
            'slug.string' => 'The Slug must be a string.',
            'slug.max' => 'The Slug may not be greater than 255 characters.',
            'slug.unique' => 'The Slug has already been taken. Please choose a different Slug.',
            'status.required' => 'The Status field is required.',
            'status.int' => 'The Status must be an integer.',
            'status.max' => 'The Status may not be greater than 2.',
        ];
    }
}

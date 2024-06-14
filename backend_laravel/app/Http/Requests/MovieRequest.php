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
            'quality' => 'int|in:1,2,3',
            'lang' => 'string|max:255',
            'notify' => 'string|max:255',
            'showtimes' => 'string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'actor' => 'required|array',
            'actor.*' => 'string|max:255',
            'director' => 'required|array',
            'director.*' => 'string|max:255',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'integer|exists:genres,id',
            'country_id' => 'required|integer',
            'category_id' => 'required|integer',
        ];
    }


    public function messages()
    {

        return [
            'name.required' => 'The movie name is required.',
            'name.string' => 'The movie name must be a string.',
            'name.max' => 'The movie name may not be greater than 255 characters.',

            'slug.required' => 'The slug is required.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug may not be greater than 255 characters.',
            'slug.unique' => 'The slug has already been taken.',

            'origin_name.required' => 'The original name is required.',
            'origin_name.string' => 'The original name must be a string.',
            'origin_name.max' => 'The original name may not be greater than 255 characters.',

            'content.required' => 'The content is required.',
            'content.string' => 'The content must be a string.',

            'type.required' => 'The movie type is required.',
            'type.int' => 'The movie type must be an integer.',
            'type.in' => 'The selected movie type is invalid.',

            'status.required' => 'The status is required.',
            'status.int' => 'The status must be an integer.',
            'status.in' => 'The selected status is invalid.',

            'poster_url.required' => 'The poster URL is required.',
            'poster_url.string' => 'The poster URL must be a string.',
            'poster_url.max' => 'The poster URL may not be greater than 255 characters.',

            'thumb_url.required' => 'The thumb URL is required.',
            'thumb_url.string' => 'The thumb URL must be a string.',
            'thumb_url.max' => 'The thumb URL may not be greater than 255 characters.',

            'is_copyright.required' => 'The copyright status is required.',
            'is_copyright.bool' => 'The copyright status must be a boolean.',

            'sub_docquyen.required' => 'The exclusive subtitle status is required.',
            'sub_docquyen.bool' => 'The exclusive subtitle status must be a boolean.',

            'chieurap.required' => 'The theater release status is required.',
            'chieurap.bool' => 'The theater release status must be a boolean.',

            'trailer_url.string' => 'The trailer URL must be a string.',
            'trailer_url.max' => 'The trailer URL may not be greater than 255 characters.',

            'time.string' => 'The time must be a string.',
            'time.max' => 'The time may not be greater than 255 characters.',

            'episode_current.string' => 'The current episode must be a string.',
            'episode_current.max' => 'The current episode may not be greater than 255 characters.',

            'episode_total.int' => 'The total number of episodes must be an integer.',
            'episode_total.max' => 'The total number of episodes may not be greater than 10.',

            'quality.string' => 'The quality must be a integer.',
            'quality.int' => 'The movie quality must be an integer.',
            'quality.in' => 'The selected movie quality is invalid.',

            'lang.string' => 'The language must be a string.',
            'lang.max' => 'The language may not be greater than 255 characters.',

            'notify.string' => 'The notification must be a string.',
            'notify.max' => 'The notification may not be greater than 255 characters.',

            'showtimes.string' => 'The showtimes must be a string.',
            'showtimes.max' => 'The showtimes may not be greater than 255 characters.',

            'year.required' => 'The year is required.',
            'year.integer' => 'The year must be an integer.',
            'year.min' => 'The year must be at least 1900.',
            'year.max' => 'The year may not be greater than the current year.',

            'actor.required' => 'The actor field is required.',
            'actor.array' => 'The actor field must be an array.',
            'actor.*.string' => 'Each actor must be a string.',
            'actor.*.max' => 'Each actor may not be greater than 255 characters.',

            'director.required' => 'The director field is required.',
            'director.array' => 'The director field must be an array.',
            'director.*.string' => 'Each director must be a string.',
            'director.*.max' => 'Each director may not be greater than 255 characters.',

            'genre_ids.array' => 'The genre IDs must be an array.',
            'genre_ids.*.integer' => 'Each genre ID must be an integer.',
            'genre_ids.*.exists' => 'Each genre ID must exist in the genres table.',

            'country_id.required' => 'The country ID field is required.',
            'country_id.integer' => 'The country ID must be an integer.',
            // 'country_id.exists' => 'The selected country ID is invalid.',

            'category_id.required' => 'The category ID field is required.',
            'category_id.integer' => 'The category ID must be an integer.',
            // 'category_id.exists' => 'The selected category ID is invalid.',
        ];
    }
}

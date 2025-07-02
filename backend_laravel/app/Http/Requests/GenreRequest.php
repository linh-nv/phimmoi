<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GenreRequest extends FormRequest
{
    public function authorize(): bool
    {
        $admin = Auth::guard('admin-api')->user();

        return $admin instanceof \App\Models\Admin;
    }

    public function rules(): array
    {
        $genreId = optional($this->route('genre'))->id;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('genres', 'slug')->ignore($genreId),
            ],
            'status' => 'required|int|max:2',
        ];
    }


    public function messages(): array
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'movie_id' => [
                'required',
                'integer',
                Rule::exists('movies', 'id')
            ],
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
            ],
            'comment' => [
                'required',
                'string',
                'max:1000'
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('movie_comments', 'id')
            ]
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'movie_id.required' => 'The movie id is required.',
            'movie_id.integer' => 'The movie id must be a int.',
            'movie_id.exists' => 'The movie not exists.',

            'user_id.required' => 'The user id is required.',
            'user_id.integer' => 'The user id must be a int.',
            'user_id.exists' => 'The user not exists.',

            'comment.required' => 'The comment id is required.',
            'comment.string' => 'The movie id must be a string.',
            'comment.max' => 'The comment may not be greater than 1000 characters.',

            'parent_id.integer' => 'The comment parent id must be a int.',
            'parent_id.exists' => 'The comment parent not exists.'
        ];
    }
}

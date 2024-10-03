<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieUserRequest extends FormRequest
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
        ];
    }
}

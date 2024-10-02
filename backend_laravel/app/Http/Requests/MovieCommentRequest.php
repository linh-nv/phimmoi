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
            'movie_id.required' => 'Phim là bắt buộc.',
            'movie_id.integer' => 'ID của phim phải là số nguyên.',
            'movie_id.exists' => 'Phim không tồn tại.',

            'user_id.required' => 'Người dùng là bắt buộc.',
            'user_id.integer' => 'ID của người dùng phải là số nguyên.',
            'user_id.exists' => 'Người dùng không tồn tại.',

            'comment.required' => 'Bình luận là bắt buộc.',
            'comment.string' => 'Bình luận phải là chuỗi văn bản.',
            'comment.max' => 'Bình luận không được vượt quá 1000 ký tự.',

            'parent_id.integer' => 'ID của bình luận cha phải là số nguyên.',
            'parent_id.exists' => 'Bình luận cha không tồn tại.'
        ];
    }
}

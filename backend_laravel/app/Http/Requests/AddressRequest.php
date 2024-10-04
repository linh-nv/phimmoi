<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        $admin = Auth::guard('admin-api')->user();

        return $admin instanceof \App\Models\Admin;
    }

    public function rules(): array
    {

        return [
            'user_id' => 'required|exists:users,id',
            'address' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,province_id',
            'district_id' => 'required|exists:districts,district_id',
            'ward_id' => 'required|exists:wards,ward_id',
        ];
    }


    public function messages(): array
    {

        return [
            'user_id.required' => 'The user ID field is required.',
            'user_id.exists' => 'The selected user does not exist.',

            'address.required' => 'The address field is required.',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address may not be greater than 255 characters.',

            'province_id.required' => 'The province ID field is required.',
            'province_id.exists' => 'The selected province does not exist.',

            'district_id.required' => 'The district ID field is required.',
            'district_id.exists' => 'The selected district does not exist.',

            'ward_id.required' => 'The commune ID field is required.',
            'ward_id.exists' => 'The selected commune does not exist.',
        ];
    }
}

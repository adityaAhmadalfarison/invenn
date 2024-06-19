<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMahasiswaRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust authorization logic if necessary
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('mahasiswa')->id,
            // Add other fields to validate for mahasiswa
        ];
    }
}

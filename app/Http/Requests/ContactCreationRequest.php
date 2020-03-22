<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ru.name' => 'required',
            'cover' => 'image|max:2000'
        ];
    }
}

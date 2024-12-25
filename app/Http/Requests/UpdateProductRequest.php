<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category_id' => 'string|max:100',
            'name' => 'string|max:100',
            'price' => 'numeric',
            'image' => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ];
    }
}

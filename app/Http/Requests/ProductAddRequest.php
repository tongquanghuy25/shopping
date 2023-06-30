<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:products|min:10',
            'price' => 'required',
            'category_id' => 'required',
            'content' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.unque' => 'Tên không được trùng nhau',
            'name.min' => 'Tên không được nhỏ hơn 10 ký tự',
            'price.required' => 'Giá không được để trống',
            'category_id.required' => 'Tên danh mục không được để trống',
            'content.required' => 'Nội dung không được để trống'
        ];
        
    }
}

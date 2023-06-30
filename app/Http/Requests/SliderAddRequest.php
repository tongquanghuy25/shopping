<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderAddRequest extends FormRequest
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
            'name' => 'required|unique:sliders|max:255|min:8',
            'description' => 'required',
            'image_path' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.unque' => 'Tên không được trùng nhau',
            'name.max' => 'Tên không được lớn hơn 255 ký tự',
            'name.min' => 'Tên không được nhỏ hơn 8 ký tự',
            'description.required' => 'Mô tả không được để trống',
            'image_path.required' => 'Ảnh không được để trống',
        ];
        
    }
}

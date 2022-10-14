<?php

namespace App\Http\Requests\v1\Api;

use Illuminate\Foundation\Http\FormRequest;

class InspectionRequest extends FormRequest
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
        $request = $this;
        return [
            'monitoring_id'=>'required',
            'title'=>'required',
          //  'before_lat' => 'required',
           // 'before_long' => 'required',
           // 'after_lat' => 'required',
           // 'after_long' => 'required',
            'remark' => 'required',
            'before_images'=>'nullable',
            'after_images' => 'nullable',
        ];
    }
}

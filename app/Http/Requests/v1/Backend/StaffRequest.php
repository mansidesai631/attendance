<?php



namespace App\Http\Requests\v1\Backend;



use Illuminate\Foundation\Http\FormRequest;



class StaffRequest extends FormRequest

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
            'name'=>'required',
            'mobile' => 'required|unique:employees',
            'email' => 'required|email|unique:employees',
            //'email' => 'required|email|unique:employees',
        ];

    }



    public function messages()

    {

        return [

            'name.required' => 'Name is required.',

            'mobile.required' => 'Mobile Number is required',

            'email.required' => 'Email is required',

            'email.email' => 'Please enter Valid email',

        ];

    }

}


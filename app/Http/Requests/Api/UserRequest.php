<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
// UserController 的专属验证器
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->method()) {
            case 'GET':
                {
                    return [
                        'id' => ['required']
                    ];
                }
            // case 'POST':
            //        return [
            //         'name' => ['required', 'max:16', 'unique:users,name'],
            //         'email' => ['required', 'unique:users,email'],
            //         'password' => ['required', 'between:6,20'],
            //         'phone' => ['unique:users,phone']
            //     ];
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            default:
                {
                    return [

                    ];
                }
        }
    }

    public function messages()
    {
        return [
            'id.required'=>'用户ID必须填写',
            'id.exists'=>'用户不存在',
            'name.unique' => '用户名已经存在',
            'name.required' => '用户名不能为空',
            'name.max' => '用户名最大长度为12个字符',
            'password.required' => '密码不能为空',
            'password.max' => '密码长度不能超过16个字符',
            'password.min' => '密码长度不能小于6个字符'
        ];
    }
}

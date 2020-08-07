<?php

namespace App\Http\Requests\Api;

class EmailRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       switch (FormRequest::getPathInfo()){
           case '/api/v1/sendEmail':
               return [
                   'email' => ['required', 'exists:users,email'],
               ];
           case '/api/v1/user/forget':
                return [
                   'captcha' => ['required', 'between:4,4'],
                   'email' => ['required', 'exists:users,email'],
                   'password' => ['required', 'between:6,20'],
               ];
       }
    }
     public function messages()
        {
            return [
                'email.required' => '邮箱不能为空',
                'email.exists' => '该邮箱未注册',
                'captcha.required'=>'验证码不能为空',
                'captcha.between' => '验证码为4位数',
                'password.required' => '新密码不能为空',
                'password.between' => '密码长度为6~20位之间',
            ];
        }
}

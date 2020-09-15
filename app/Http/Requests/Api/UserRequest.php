<?php

namespace App\Http\Requests\Api;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // require  必填
        // max      最大长度
        // unique:table,字段名   在表中唯一
        // between 字符长度在多少直间
        switch (FormRequest::getPathInfo()){
            case '/api/v1/sign':
                return [
                    'name' => ['required', 'max:16', 'unique:users,name'],
                    'email' => ['required','email', 'unique:users,email'],
                    'password' => ['required', 'between:6,20'],
                    'phone' => ['unique:users,phone']
                ];
            case '/api/v1/login':
                return [
                    'name' => ['required', 'max:16', 'exists:user_auths,login_name'],
                    'password' => ['required', 'between:6,20'],
                ];
            case '/api/v1/admin/login':
                return [
                    'name'=>['required','max:16','exists:user_auths,login_name'],
                    'password'=>['required','between:6,20']
                ];
            case '/api/v1/admin/update':
                return [
                    'name' => ['max:16','unique:users,name'],
                    'email' => ['unique:users,email'],
                    'password' => ['between:6,20'],
                    'pass' => ['between:6,20'],
                    'phone' => ['unique:users,phone'],
                    'avatar_url'=>[ 'between:3,100','url'],
                ];
            case '/api/v1/user/modify':
                return [
                    'phone'=>['unique:users,phone'],
                    'email'=>['unique:users,email'],
                    'password'=>['between:6,20'],
                    'intro'=>['between:10,50']
                ];
            case '/api/v1/admin/user/remove':
                return [
                    'id'=>['required']
                ];

        }
    }
    public function messages()
    {
        return [
            'name.required'=>'用户名不能为空',
            'name.exists'=>'用户名或密码错误',
            'name.max' => '用户名长度不能超过16个字符',
            'name.unique' => '用户名已经存在',
            'email.required' => '邮箱不能为空',
            'email.unique' => '邮箱已经存在',
            'email.email' => '邮箱地址不正确',
            'phone.unique' => '手机号已存在',
            'phone.phone' => '手机号长度不正确',
            'password.required' => '密码不能为空',
            'password.between' => '密码长度为6~20位之间',
            'pass.required' => '新密码不能为空',
            'pass.between' => '密码长度为6~20位之间',
            'id.required'=>'id必须填写',
            'avatar_url'=>'头像地址长度应在1~100字之间',
            'avatar_url.url'=>'头像地址格式不正确'
        ];
    }
}

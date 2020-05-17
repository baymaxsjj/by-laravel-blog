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
                    'email' => ['required', 'unique:users,email'],
                    'password' => ['required', 'between:6,20'],
                    'phone' => ['unique:users,phone']
                ];
            case '/api/v1/login':
                return [
                    'name' => ['required', 'max:16', 'exists:users,name'],
                    'password' => ['required', 'between:6,20'],
                ];
            case '/api/v1/admin/login':
                return [
                    'name'=>['required','max:16','exists:users,name'],
                    'password'=>['required','between:6,20']
                ];
            case '/api/v1/admin/update':
                return [
                    'name' => ['max:16','unique:users,name'],
                    'email' => ['unique:users,email'],
                    'password' => ['required','between:6,20'],
                    'pass' => ['between:6,20'],
                    'phone' => ['unique:users,phone'],
                    'avatar_url'=>[ 'between:3,100'],
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
            'name.exists'=>'用户名不存在',
            'name.max' => '用户名长度不能超过16个字符',
            'name.unique' => '用户名已经存在',
            'email.required' => '邮箱不能为空',
            'email.unique' => '邮箱已经存在',
            'phone.unique' => '手机号已存在',
            'password.required' => '密码不能为空',
            'password.between' => '密码长度为6~20位之间',
            'old_password.required' => '旧密码不能为空',
            'old_password.between' => '密码长度为6~20位之间',
            'new_password.required' => '新密码不能为空',
            'new_password.between' => '密码长度为6~20位之间',
            // 'password.max' => '密码长度不能超过32个字符',
            // 'password.min' => '密码长度不能少于6个字符',
            'id.required'=>'id必须填写',
            'id.exists' => '用户id不存在'
        ];
    }
}

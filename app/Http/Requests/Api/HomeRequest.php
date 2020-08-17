<?php

namespace App\Http\Requests\Api;

class HomeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (FormRequest::getPathInfo()){
            case '/api/v1/admin/show/add':
                return [
                    'title'=>['max:50'],
                    'info'=>['between:1,100'],
                    'img_url'=>['required'],
                ];
            case '/api/v1/admin/show/remove':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/admin/show/update':
                return [
                    'id'=>['required'],
                    'title'=>['max:50'],
                    'info'=>['max:100'],
                    'img_url'=>['required'],
                ];

        }
    }
    public function messages(){
        return [
            'title.max'=>'轮播标题不能超过50字',
            'link.url'=>'轮播域名格式不正确',
            'info.max'=>'轮播介绍不能超过100字',
            'img_url'=>'网站图标不能为空',
            'id.required'=>'id不能为空',
        ];
    }
}

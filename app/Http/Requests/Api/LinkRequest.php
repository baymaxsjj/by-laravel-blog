<?php

namespace App\Http\Requests\Api;

class LinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (FormRequest::getPathInfo()){
            case '/api/v1/admin/link/add':
                return [
                    'name'=>['required','max:20'],
                    'link'=>['required','url'],
                    'info'=>['required','between:5,50'],
                    'imgUrl'=>['required']
                ];
            case '/api/v1/admin/link/remove':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/link/list':
                return [
                    'type'=>['required']
                ];
            case '/api/v1/admin/link/update':
                return [
                    'id'=>['required'],
                    'name'=>['required','max:20'],
                    'link'=>['required'],
                    'info'=>['required','between:5,50'],
                    'type'=>['required']
                ];

        }
    }
    public function messages(){
        return [
            'name.required'=>'网站名称不能为空',
            'name.max'=>'网站名称不能超过20字',
            'link.require'=>'网站域名不能为空',
            'link.url'=>'网站域名格式不正确',
            'info.require'=>'个人介绍不能为空',
            'info.between'=>'个人介绍应在5~50字之间',
            'imgUrl'=>'网站图标不能为空',
            'id.required'=>'id不能为空',
        ];
    }
}

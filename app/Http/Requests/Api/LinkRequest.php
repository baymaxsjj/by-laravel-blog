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
                    'name'=>['required','max:30'],
                    'link'=>['required','url'],
                    'info'=>['required','between:1,50'],
                    'imgUrl'=>['required'],
                    'type'=>['required']
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
                    'name'=>['required','max:30'],
                    'link'=>['required'],
                    'info'=>['required','between:1,50'],
                    'type'=>['required']
                ];

        }
    }
    public function messages(){
        return [
            'name.required'=>'网站名称不能为空',
            'name.max'=>'网站名称不能超过30字',
            'link.require'=>'网站域名不能为空',
            'link.url'=>'网站域名格式不正确',
            'info.require'=>'网站介绍不能为空',
            'info.between'=>'网站介绍应在1~50字之间',
            'imgUrl'=>'网站图标不能为空',
            'id.required'=>'id不能为空',
            'type.required'=>'类型不能为空'
        ];
    }
}

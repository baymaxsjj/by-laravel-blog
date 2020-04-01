<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

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
            case '/api/v1/user/link/apply':
                return [
                    'name'=>['required','max:20'],
                    'link'=>['required'],
                    'info'=>['required','between:5,50'],
                    'imgUrl'=>['required']
                ];
            case '/api/v1/admin/link/add':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/admin/link/remove':
                return [
                    'id'=>['required']
                ];
            
        }
    }
    public function message(){
        return [
            'name.required'=>'网站名称不能为空',
            'name.max'=>'网站名称不能超过20位',
            'link.require'=>'网站域名不能为空',
            'info.require'=>'个人介绍不能为空',
            'info.between'=>'个人介绍应在5~50字之间',
            'imgUrl'=>'网站图标不能为空',
        ];
    }
}

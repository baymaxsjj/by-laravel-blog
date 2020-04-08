<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RouteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (FormRequest::getPathInfo()){
            case '/api/v1/admin/route/add':
                return [
                    'data'=>['required','between:5,30'],
                    'category'=>['required','between:5,30'],
                    'content'=>['required','between:5,100']
                ];
            case '/api/v1/admin/route/remove':
                return [
                    'id'=>['required']
                ];

        }
    }
    public function message(){
        return [
            'data.required'=>'日期不能为空',
            'data.between'=>'日期5~30字之间',
            'category.required'=>'类别内容不能为空',
            'category.between'=>'类别应在5~30字之间',
            'content.required'=>'内容不能为空',
            'content.between'=>'应在5~100字之间',
            'id.require'=>'id不能为空'
        ];
    }
}

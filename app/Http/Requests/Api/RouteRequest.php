<?php

namespace App\Http\Requests\Api;

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
                    'data'=>['required','between:1,30'],
                    'category'=>['required','between:1,50'],
                    'content'=>['required','between:1,100']
                ];
            case '/api/v1/admin/route/remove':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/admin/route/update':
                return [
                    'id'=>['required'],
                    'data'=>['required','between:1,30'],
                    'category'=>['required','between:1,50'],
                    'content'=>['required','between:1,100']
                ];

        }
    }
    public function messages(){
        return [
            'data.required'=>'日期不能为空',
            'data.between'=>'日期1~30字之间',
            'category.required'=>'类别内容不能为空',
            'category.between'=>'类别应在1~50字之间',
            'content.required'=>'内容不能为空',
            'content.between'=>'应在1~100字之间',
            'id.required'=>'id不能为空',
            'content.required'=>'内容不能为空',
            'content.between'=>'内容应在1~100字之间'
        ];
    }
}

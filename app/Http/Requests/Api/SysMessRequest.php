<?php

namespace App\Http\Requests\Api;

class SysMessRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (FormRequest::getPathInfo()){
            case '/api/v1/admin/sysmess/add':
                return [
                    'title'=>['max:30'],
                    'content'=>['required'],
                ];
            case '/api/v1/admin/sysmess/remove':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/admin/sysmess/update':
                return [
                    'id'=>['required'],
                    'title'=>['max:30'],
                    'content'=>['required'],
                ];

        }
    }
    public function messages(){
        return [
            'title.max'=>'公告标题不能超过30字',
            'id.required'=>'id不能为空',
            'content.required'=>'公告内容不能为空',
        ];
    }
}

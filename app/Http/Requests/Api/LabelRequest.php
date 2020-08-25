<?php

namespace App\Http\Requests\Api;

class LabelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (FormRequest::getPathInfo()){
            case '/api/v1/admin/label/add':
                return [
                    'label'=>['required'],
                ];
            case '/api/v1/admin/label/remove':
                return [
                    'id'=>['required']
                ];
        }
    }
    public function messages(){
        return [
            'label.reqiduired'=>'标签内容不能为空',
            'id.reqiduired'=>'id不能为空'
        ];
    }
}
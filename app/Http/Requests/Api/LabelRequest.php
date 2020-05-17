<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

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
                    'label'=>['required','between:1,10'],
                ];
            case '/api/v1/admin/label/remove':
                return [
                    'id'=>['required']
                ];
        }
    }
    public function message(){
        return [
            'label.reqiduired'=>'标签内容不能为空',
            'label.between'=>'留言应在5~50字之间',
            'id.reqiduired'=>'管理员id不能为空'
        ];
    }
}

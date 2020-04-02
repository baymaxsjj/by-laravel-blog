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
            case '/api/v1/admin/article/add':
                return [
                    'title'=>['required','between:5,30'],
                    'desc'=>['between:10,50'],
                    'content'=>['required'],
                    'label_id'=>['required'],
                ];
            case '/api/v1/admin/article/remove':
                return [
                    'id'=>['required']
                ];
        }
    }
    public function message(){
        return [
            'title.reqiduired'=>'标题内容不能为空',
            'title.between'=>'标题应在5~30字之间',
            'id.reqiduired'=>'管理员id不能为空',
            'desc.between'=>'文章介绍应在50~50字之间',
            'content.reqiduired'=>'文章内容不能为空',
            'label_id.reqiduired'=>'文章标签不能为空'
        ];
    }
}

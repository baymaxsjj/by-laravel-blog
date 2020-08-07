<?php

namespace App\Http\Requests\Api;

class MessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (FormRequest::getPathInfo()){
            case '/api/v1/message/add':
                return [
                    'message'=>['required','between:1,500'],
                    'tourist'=>['between:1,10'],
                    'qq'=>['between:3,11'],
                    'article_id'=>['required'],
                ];
            case '/api/v1/admin/message/remove':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/message/list':
                return [
                    'id'=>['required']
                ];
        }
    }
    public function messages(){
        return [
            'message.required'=>'留言内容不能为空',
            'message.between'=>'留言应在1~200字之间',
            'article_id'=>'文章id不能为空',
            'id.require'=>'文章id不能为空',
            'tourist.between'=>'tourist应在1~10字之间',
            'qq.between'=>'qq号应在3~11数之间'
        ];
    }
}

<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

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
            case '/api/v1/user/message/add':
                return [
                    'message'=>['required','between:5,50'],
                    'article_id'=>['required']
                ];
            case '/api/v1/admin/message/remove':
                return [
                    'id'=>['required']
                ];
        }
    }
    public function message(){
        return [
            'message.required'=>'留言内容不能为空',
            'message.between'=>'留言应在5~50字之间',
            'article_id'=>'文章id不能为空',
            'id.require'=>'文章id不能为空'
        ];
    }
}

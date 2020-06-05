<?php

namespace App\Http\Requests\Api;

class ReplyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (FormRequest::getPathInfo()){
            case '/api/v1/user/reply/add':
                return [
                    'reply'=>['required','between:1,200'],
                    'mess_id'=>['required']
                ];
            case '/api/v1/admin/reply/remove':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/reply/list':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/admin/reply/alist':
                return [
                    'id'=>['required']
                ];
        }
    }
    public function messages(){
        return [
            'reply.required'=>'回复内容不能为空',
            'reply.between'=>'回复应在1~200字之间',
            'mess_id.required'=>'回复者id不能为空',
            'id.require'=>'文章id不能为空'
        ];
    }
}

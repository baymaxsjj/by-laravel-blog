<?php

namespace App\Http\Requests\Api;
class ArticleRequest extends FormRequest
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
                    'title'=>['required'],
                    'desc'=>['required'],
                    'content'=>['required']
                ];
            case '/api/v1/admin/article/update':
                return [
                    'id'=>['required'],
                    'title'=>['required'],
                    'desc'=>['required'],
                    'content'=>['required']
                ];
            case '/api/v1/admin/article/remove':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/blog/content':
                return [
                    'id'=>['required','exists:articles,id']
                ];
            case '/api/v1/admin/remove':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/blog/list':
                return [
                    'label'=>['exists:labels,label'],
                    'class'=>['exists:articles,classty'],
                    'search'=>['between:1,50']
                ];
            case '/api/v1/blog/search':
                return [
                    'search'=>['between:1,50'],
                ];
            case '/api/v1/blog/click':
                return [
                    'id'=>['required','exists:articles,id'],
                ];
        }
    }
    public function messages(){
        return [
            'title.reqiduired'=>'标题内容不能为空',
            'id.reqiduired'=>'文章id不能为空',
            'id.exists'=>'文章不存在',
            'desc.reqiduired'=>'文章介绍不能为空',
            'content.reqiduired'=>'文章内容不能为空',
            'class.exists'=>'文章类别不存在',
            'label.exists'=>'文章标签不存在',
            'search.between'=>'查询内容应在1~50字之间'
        ];
    }
}

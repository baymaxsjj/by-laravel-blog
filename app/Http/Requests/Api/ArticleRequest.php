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
                    'title'=>['required','between:5,30'],
                    'desc'=>['between:10,50'],
                    'content'=>['required']
                ];
            case '/api/v1/admin/article/update':
                return [
                    'id'=>['required'],
                    'title'=>['required','between:5,30'],
                    'desc'=>['between:10,50'],
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
                    'label'=>['between:1,10','exists:labels,label'],
                    'class'=>['between:1,10','exists:articles,classty'],
                    'search'=>['between:1,50']
                ];
            case '/api/v1/blog/search':
                return [
                    'search'=>['between:1,50'],
                ];
        }
    }
    public function messages(){
        return [
            'title.reqiduired'=>'标题内容不能为空',
            'title.between'=>'标题应在5~30字之间',
            'id.reqiduired'=>'文章id不能为空',
            'id.exists'=>'文章不存在',
            'desc.between'=>'文章介绍应在50~50字之间',
            'content.reqiduired'=>'文章内容不能为空',
            'class.between'=>'类别应在1~10字之间',
            'class.exists'=>'文章类别不存在',
            'label.between'=>'标签应在1~10字之间',
            'label.exists'=>'文章标签不存在'
        ];
    }
}

<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class MusicRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (FormRequest::getPathInfo()){
          case '/api/v1/admin/music/add':
              return [
                 'music_id'=>['required','between:5,50','unique:musics,music_id'],
                 'title'=>['required','between:1,50'],
                 'name'=>['required','between:1,50'],
                 'type'=>['required','between:1,10']
              ];
            case '/api/v1/admin/music/remove':
                return [
                    'id'=>['required']
                ];
            case '/api/v1/admin/music/update':
                return [
                    'music_id'=>['required','between:5,50'],
                    'title'=>['required','between:1,20'],
                    'name'=>['required','between:1,50']
                ];

        }

    }
    public function message(){
        return [
            'music_id.required'=>'音乐id不能为空',
            'music_id.between'=>'音乐id不能超过50位',
            'title.require'=>'音乐标题不能为空',
            'title.between'=>'音乐标题应在1~20字之间',
            'name.require'=>'音乐作者不能为空',
            'name.between'=>'音乐作者应在1~10字之间',
            'id'=>'网站图标不能为空',
        ];
    }
}

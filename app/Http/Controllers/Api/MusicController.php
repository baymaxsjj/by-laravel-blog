<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Music;
use App\Http\Requests\Api\MusicRequest;
class MusicController extends Controller
{
    //
    function list(){
        $data=['music_id','title','name','type'];
        $list=Music::all($data);
        return $this->success($list);
    }
    function add(MusicRequest $request){
        $music=Music::create($request->all());
        return $this->message('添加成功');
    }
    function remove(MusicRequest $request){
       $id=$request->input('id');
       $music=Music::withTrashed()->find($id);
       if(is_null($music->deleted_at)){
           $boo=Music::find($id)->delete();
           return $this->message('添加成功');
       }else{
           $boo=Music::withTrashed()->find($id)->restore();
           return $this->message('移除成功');
       }
    }
    public function update(MusicRequest $request){
        $id=$request->input('id');
        $music=Music::find($id);
        $boo=$music->update($request->all());
        if(!$boo){
            return $this->message('修改失败');
        }
        return $this->message('修改成功');
    }

    function alist(){
        $music=Music::withTrashed()->orderBy('created_at','desc')->paginate(5);
        return $this->success($music);
    }
    // 渠道音乐接口信息
	function music_channel_urls($value, $type = 'query', $site = 'netease', $page = 1){
	 if (!$value) {
	        return;
	    }
	    $query             = ('query' === $type) ? $value : '';
	    $songid            = ('songid' === $type || 'lrc' === $type) ? $value : '';
        // 获取歌曲信息
	    $radio_search_urls = [
	        'netease'            => [
	            'method'         => 'POST',
	            'url'            => 'http://music.163.com/api/linux/forward',
	            'referer'        => 'http://music.163.com/',
	            'proxy'          => false,
	            'body'           => encode_netease_data([
	                'method'     => 'POST',
	                'url'        => 'http://music.163.com/api/cloudsearch/pc',
	                'params'     => [
	                    's'      => $query,
	                    'type'   => 1,
	                    'offset' => $page * 10 - 10,
	                    'limit'  => 10
	                ]
	            ])
	        ],
	        'kugou'              => [
	            'method'         => 'GET',
	            'url'            => MC_INTERNAL ?
	                'http://songsearch.kugou.com/song_search_v2' :
	                'http://mobilecdn.kugou.com/api/v3/search/song',
	            'referer'        => MC_INTERNAL ? 'http://www.kugou.com' : 'http://m.kugou.com',
	            'proxy'          => false,
	            'body'           => [
	                'keyword'    => $query,
	                'platform'   => 'WebFilter',
	                'format'     => 'json',
	                'page'       => $page,
	                'pagesize'   => 10
	            ]
	        ],
	        'kuwo'               => [
	            'method'         => 'GET',
	            'url'            => 'http://search.kuwo.cn/r.s',
	            'referer'        => 'http://player.kuwo.cn/webmusic/play',
	            'proxy'          => false,
	            'body'           => [
	                'all'        => $query,
	                'ft'         => 'music',
	                'itemset'    => 'web_2013',
	                'pn'         => $page - 1,
	                'rn'         => 10,
	                'rformat'    => 'json',
	                'encoding'   => 'utf8'
	            ]
	        ],
	        'qq'                 => [
	            'method'         => 'GET',
	            'url'            => 'http://c.y.qq.com/soso/fcgi-bin/search_for_qq_cp',
	            'referer'        => 'http://m.y.qq.com',
	            'proxy'          => false,
	            'body'           => [
	                'w'          => $query,
	                'p'          => $page,
	                'n'          => 10,
	                'format'     => 'json'
	            ],
	            'user-agent'     => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
	        ],
	    ];
        // 获取歌曲播放地址
	    $radio_song_urls = [
	        'netease'           => [
	            'method'        => 'POST',
	            'url'           => 'http://music.163.com/api/linux/forward',
	            'referer'       => 'http://music.163.com/',
	            'proxy'         => false,
	            'body'          => encode_netease_data([
	                'method'    => 'GET',
	                'url'       => 'http://music.163.com/api/song/detail',
	                'params'    => [
	                  'id'      => $songid,
	                  'ids'     => '[' . $songid . ']'
	                ]
	            ])
	        ],
	        'kugou'             => [
	            'method'        => 'GET',
	            'url'           => 'http://m.kugou.com/app/i/getSongInfo.php',
	            'referer'       => 'http://m.kugou.com/play/info/' . $songid,
	            'proxy'         => false,
	            'body'          => [
	                'cmd'       => 'playInfo',
	                'hash'      => $songid
	            ],
	            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
	        ],
	        'kuwo'              => [
	            'method'        => 'GET',
	            'url'           => 'http://player.kuwo.cn/webmusic/st/getNewMuiseByRid',
	            'referer'       => 'http://player.kuwo.cn/webmusic/play',
	            'proxy'         => false,
	            'body'          => [
	                'rid'       => 'MUSIC_' . $songid
	            ]
	        ],
	        'qq'                => [
	            'method'        => 'GET',
	            'url'           => 'http://c.y.qq.com/v8/fcg-bin/fcg_play_single_song.fcg',
	            'referer'       => 'http://m.y.qq.com',
	            'proxy'         => false,
	            'body'          => [
	                'songmid'   => $songid,
	                'format'    => 'json'
	            ],
	            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
	        ],
	    ];
        // 获取歌词地址
	    $radio_lrc_urls = [
	        'netease'           => [
	            'method'        => 'POST',
	            'url'           => 'http://music.163.com/api/linux/forward',
	            'referer'       => 'http://music.163.com/',
	            'proxy'         => false,
	            'body'          => encode_netease_data([
	                'method'    => 'GET',
	                'url'       => 'http://music.163.com/api/song/lyric',
	                'params'    => [
	                  'id' => $songid,
	                  'lv' => 1
	                ]
	            ])
	        ],
	        'kugou'             => [
	            'method'        => 'GET',
	            'url'           => 'http://m.kugou.com/app/i/krc.php',
	            'referer'       => 'http://m.kugou.com/play/info/' . $songid,
	            'proxy'         => false,
	            'body'          => [
	                'cmd'        => 100,
	                'timelength' => 999999,
	                'hash'       => $songid
	            ],
	            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X] AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
	        ],
	        'kuwo'              => [
	            'method'        => 'GET',
	            'url'           => 'http://m.kuwo.cn/newh5/singles/songinfoandlrc',
	            'referer'       => 'http://m.kuwo.cn/yinyue/' . $songid,
	            'proxy'         => false,
	            'body'          => [
	                'musicId' => $songid
	            ],
	            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
	        ],
	        'qq'                => [
	            'method'        => 'GET',
	            'url'           => 'http://c.y.qq.com/lyric/fcgi-bin/fcg_query_lyric.fcg',
	            'referer'       => 'http://m.y.qq.com',
	            'proxy'         => false,
	            'body'          => [
	                'songmid'   => $songid,
	                'format'    => 'json',
	                'nobase64'  => 1,
	                'songtype'  => 0,
	                'callback'  => 'c'
	            ],
	            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
	        ],
	    ];
	    if ('query' === $type) {
	        return $radio_search_urls[$site];
	    }
	    if ('songid' === $type) {
	        return $radio_song_urls[$site];
	    }
	    if ('lrc' === $type) {
	        return $radio_lrc_urls[$site];
	    }
	    return;
	}

}

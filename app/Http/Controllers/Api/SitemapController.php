<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\App;
class SitemapController extends Controller
{
    //
	 public function sitemap () {

	        // 创建一个生成站点地图的对象
	        $sitemap_contents = App::make("sitemap");
	        // 设置缓存
	        $sitemap_contents->setCache('laravel.sitemap_contents', 3600);
	        // 从数据库获取全部的博客文章
	        $blogs = Article::orderBy('created_at', 'desc')->get();
	        // 添加全部博客文章到站点地图
	        foreach ($blogs as $blog)
	        {
	            $url = env('APP_URL').'/blog/'.$blog->id;
	            $sitemap_contents->add($url, $blog->updated_at,'1.0','daily');
	        }
	        // 渲染站点地图(options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
	        // return env('APP_URL');
            //test
            return $sitemap_contents->render('xml');
	    }
}

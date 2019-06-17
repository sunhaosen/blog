<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');
Route::rule('list','index/Index/list');
Route::rule('show','index/Index/show');
Route::rule('login','index/Login/index');
Route::rule('register','index/Register/index');
Route::rule('member','index/Member/index');
Route::rule('add','index/Index/add');
Route::rule('blog_list','index/Member/blog_list');
Route::rule('comment_list','index/Member/comment_list');

//Route::rule('login_d','api/Login/index','post');
//Route::resource('blog','api/index');

return [
	
];

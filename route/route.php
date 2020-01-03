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
Route::allowCrossDomain();

//一般路由规则，访问的url为：v1/address/1,对应的文件为Address类下的read方法
Route::get(':version/address/:id','api/:version.admin/address');

Route::resource(':version/admin','api/:version.admin');       //资源路由，详情查看tp手册资源路由一章
Route::resource(':version/menu','api/:version.menu');       //资源路由，详情查看tp手册资源路由一章
Route::post(':version/admin/login','api/:version.admin/login');//登录路由

//生成access_token，post访问Token类下的token方法
Route::post(':version/token','api/:version.token/token');
Route::post(':version/token/refresh','api/:version.token/refresh');

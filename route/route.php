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

use think\facade\Route;

Route::allowCrossDomain();//解决跨域

//一般路由规则，访问的url为：v1/address/1,对应的文件为Address类下的read方法

Route::resource('admin/:version/admin','api/:version.admin');       //管理员管理路由
Route::resource('admin/:version/role','api/:version.role');        //角色管理路由
Route::resource('admin/:version/menu','api/:version.menu');       //菜单管理路由
Route::resource('admin/:version/auth','api/:version.auth');       //权限管理路由
Route::resource('admin/:version/log','api/:version.log');       //日志管理路由
Route::resource('admin/:version/index','api/:version.index');       //index路由
Route::resource('admin/:version/user','api/:version.user');       //用户管理路由
Route::resource('admin/:version/merchant','api/:version.merchant');       //商户管理路由

Route::post('admin/:version/admin/login','api/:version.admin/login');//登录路由
Route::get('admin/:version/cache/clear','api/:version.cache/clear');//缓存清除

//生成access_token，post访问Token类下的token方法
Route::post(':version/token','api/:version.token/token');
Route::post(':version/token/refresh','api/:version.token/refresh');

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

Route::resource('admin/:version/admin','admin/:version.admin');       //管理员管理路由
Route::resource('admin/:version/role','admin/:version.role');        //角色管理路由
Route::resource('admin/:version/menu','admin/:version.menu');       //菜单管理路由
Route::resource('admin/:version/auth','admin/:version.auth');       //权限管理路由
Route::resource('admin/:version/log','admin/:version.log');       //日志管理路由
Route::resource('admin/:version/index','admin/:version.index');       //index路由
Route::resource('admin/:version/user','admin/:version.user');       //用户管理路由
Route::resource('admin/:version/merchant','admin/:version.merchant');       //商户管理路由

Route::post('admin/:version/admin/login','admin/:version.admin/login');//登录路由
Route::get('admin/:version/cache/clear','admin/:version.cache/clear');//缓存清除



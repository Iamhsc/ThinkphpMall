<?php

use think\facade\Route;

//Route::allowCrossDomain();//解决跨域

//一般路由规则，访问的url为：v1/address/1,对应的文件为Address类下的read方法

Route::get('merchant/my','merchant/info/read');   //获取个人信息
Route::put('merchant/my','merchant/info/update'); //更新个人信息
Route::get('merchant/order','merchant/order/index');
Route::get('merchant/order_details/:id','merchant/order/read');
Route::put('merchant/order/:id','merchant/order/update');
Route::post('merchant/option','merchant/options/save'); //上传文件
Route::get('merchant/option','merchant/options/read'); //上传文件
//Route::get('print','index/print');
//Route::get('print','index/print');

Route::post('merchant/login','merchant/public/login');//登录路由

<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/4/20
 * Time: 14:14
 */

namespace app\admin\controller\v1;


use think\Controller;
use think\facade\Cache;

class CacheController extends Controller
{
    public function clear(){
        $c=Cache::store('redis')->clear();
        if(!$c){
            exit('清除缓存失败');
        }
        exit('清除缓存成功');
    }
}
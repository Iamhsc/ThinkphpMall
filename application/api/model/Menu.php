<?php

namespace app\api\model;

use app\api\controller\Send;
use think\facade\Cache;
use think\Model;
use think\Request;

class Menu extends Model
{
    public static $menuTitle='';

    public static function getAllChild($uid, $pid = 0, $level = 0, $menus = [])
    {
        $menuTrees = [];
        if ($level == 0) {
            $menuTrees = Cache::store('redis')->get('admin_all_child_menu_'.$uid);
        }
        if (empty($menuTrees)) {
            if (empty($menus)) {
                $map['status'] = 1;
                $field = 'id,pid,title,icon,ctrl';
                $menus = self::where($map)->order('sort asc,id asc')->column($field);
                $menus = array_values($menus);
            }
            foreach ($menus as $key => $value) {
                if ($value['pid'] == $pid) {
                    if (!Role::checkAuth($uid, $value['id'])) {
                        unset($menus[$key]);
                        continue;
                    }
                    unset($menus[$key],$value['pid']);
                    $value['childs'] = self::getAllChild($uid, $value['id'], $level + 1, $menus);
                    $menuTrees[] = $value;
                }
            }
            Cache::store('redis')->set('admin_all_child_menu_'.$uid, $menuTrees, 0);
        }
        return $menuTrees;
    }

    /**
     * 获取当前访问节点id
     * @param Request $request
     * @return mixed
     */
    public static function getMenuInfo(Request $request)
    {
        $controller = explode('.', $request->controller())[1];  //拿到controller
        $action = $request->action();                                    //拿到action
        $cache_key=md5($controller.'_'.$action.'_info');
        $menuInfo=Cache::store('redis')->get($cache_key);
        if (empty($menuInfo)){
            $map=['ctrl'=>$controller,'action'=>$action];
            $menuInfo=db('menu')->where($map)->field('id,title')->find();
            Cache::store('redis')->set($cache_key, $menuInfo, 0);
        }
        return $menuInfo;
    }
}

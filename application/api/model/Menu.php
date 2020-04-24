<?php

namespace app\api\model;

use app\api\controller\Send;
use think\Exception;
use think\facade\Cache;
use think\Model;
use think\Request;

class Menu extends Model
{
    public static $menuTitle = '';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 格式化创建时间
    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
    }

    // 格式化更新时间
    public function getUpdateTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
    }

    /**
     * 查询指定角色权限菜单
     * @param $role_id
     * @param int $pid
     * @param int $level
     * @param array $menus
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getRoleAuthChildMenu($role_id, $pid = 0, $level = 0, $menus = [])
    {
        $menuTrees = [];
        if (empty($menuTrees)) {
            if (empty($menus)) {
                $field = 'id,pid,title';
                $menus = self::order('sort asc,id asc')->field($field)->select()->toArray();
                $menus = array_values($menus);
            }
            foreach ($menus as $key => $value) {
                if ($value['pid'] == $pid) {
                    $value['selected'] = $role_id == 1 ? true : in_array($value['id'], Role::getRoleAuth($role_id)) ? true : false;

                    $value['children'] = self::getRoleAuthChildMenu($role_id, $value['id'], $level + 1, $menus);
                    // 如果不再有子节点，删除掉children
                    if (!$value['children']) {
                        unset($value['children']);
                    }
                    $menuTrees[] = $value;
                }
            }
        }
        return $menuTrees;
    }

    /**
     * 查询当前用户权限菜单
     * @param $uid
     * @param int $pid
     * @param int $level
     * @param array $menus
     * @return array|mixed
     */
    public static function getAuthChildMenu($uid, $pid = 0, $level = 0, $menus = [])
    {
        $menuTrees = [];
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
//                        unset($menus[$key]);
                        continue;
                    }
                    unset($menus[$key], $value['pid']);
                    $value['children'] = self::getAuthChildMenu($uid, $value['id'], $level + 1, $menus);
                    // 如果不再有子节点，删除掉children
                    if (!$value['children']) {
                        unset($menus[$key], $value['children']);
                    }
                    $menuTrees[] = $value;
                }
            }
        }
        return $menuTrees;
    }

    /**
     * 查询所有菜单
     * @param int $pid
     * @param int $level
     * @param array $menus
     * @return array|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAllChildMenu($pid = 0, $level = 0, $menus = [])
    {
        $menuTrees = [];
        if (empty($menuTrees)) {
            if (empty($menus)) {
                $menus = self::order('sort asc,id asc')->select()->toArray();
                $menus = array_values($menus);
            }
            foreach ($menus as $key => $value) {
                if ($value['pid'] == $pid) {
                    $value['children'] = self::getAllChildMenu($value['id'], $level + 1, $menus);
                    // 如果不再有子节点，删除掉children
                    if (!$value['children']) {
                        unset($value['children']);
                    }
                    $menuTrees[] = $value;
                }
            }
        }
        return $menuTrees;
    }

    /**
     * 获取当前访问节点id
     * @param Request $request
     * @return array|\PDOStatement|string|Model|null
     */
    public static function getMenuInfo(Request $request)
    {
        $controller = explode('.', $request->controller())[1];  //拿到controller
        $action = $request->action();                                    //拿到action
        $map = ['ctrl' => $controller, 'action' => $action];
        $menuInfo['url'] = $controller . '/' .$action;
        try{
            $menuInfo['menu'] = Menu::where($map)->field('id,title')->find();
            return $menuInfo;
        }catch (\Exception $e){
            return [];
        }
    }
}

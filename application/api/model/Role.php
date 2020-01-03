<?php

namespace app\api\model;

use think\Db;
use think\Exception;
use think\facade\Cache;
use think\Model;

class Role extends Model
{
    /**
     * 检查访问权限
     * @param string $uid 管理员信息
     * @param $id 要检查的菜单id
     * @return bool
     */
    public static function checkAuth($uid='', $id)
    {
        $admin_info = Cache::store('redis')->get('admin_info_' . $uid);
        if ($uid == 1 || $admin_info['role_id'] == 1) {
            return true;
        }
        //从缓存中获取当前角色权限
        $roleAuth = Cache::store('redis')->get('role_auth_' . $uid);
        if (!$roleAuth) {
            //从数据库查询当前用户所属角色权限id集
            $roleAuth = self::getRoleAuth($admin_info['role_id']);
            //把当前角色所有权限存缓存
            Cache::store('redis')->set('role_auth_' . $admin_info['uid'], 0);
        }
        if (!$roleAuth) return false;
        return in_array($id, $roleAuth);
    }

    /**
     * 获取指定角色权限id集
     * @param $id
     * @return array
     */
    public static function getRoleAuth($id)
    {
        return db('role_auth')->where('role_id', 'eq', $id)->column('auth_id');
    }
}

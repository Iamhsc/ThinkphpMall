<?php

namespace app\admin\model;

use think\Db;
use think\Exception;
use think\facade\Cache;
use think\Model;

class Role extends Model
{
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
     * 检查访问权限
     * @param int $uid 管理员信息
     * @param $id 要检查的菜单id
     * @return bool
     */
    public static function checkAuth($uid = 0 , $id)
    {
        try {
            $admin_info = Admin::where(['id' => $uid])->field('role_id')->find();
        }catch (\Exception $e){}
//        Cache::store('redis')->get('admin_info_' . $uid);
        if ($uid == 1 || $admin_info['role_id'] == 1) {
            return true;
        }
        //从数据库查询当前用户所属角色权限id集
        $roleAuth = self::getRoleAuth($admin_info['role_id']);
        if (!$roleAuth)
            return false;
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

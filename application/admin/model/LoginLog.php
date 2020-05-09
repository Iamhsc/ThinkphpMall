<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/4/24
 * Time: 17:29
 */

namespace app\admin\model;

use think\facade\Log;
use think\Model;

class LoginLog extends Model
{
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 格式化登录时间
    public function getLoginTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
    }

    // 获取登陆ip
    public function setLoginIpAttr($value)
    {
        return get_client_ip();
    }

    /**
     * @param $uid
     * @param $status
     */
    public static function writeLoginLog($uid, $status)
    {
        try {
            self::create([
                'login_uid' => $uid,
                'login_ip' => '',
                'login_area' => getLocationByIp(),
                'login_time' => time(),
                'login_status' => $status
            ]);

            $id = self::order('id desc')->limit(100,1)->column('id');
            if ($id)//数据超过100条删除最旧的
                self::where(['id'=>$id])->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
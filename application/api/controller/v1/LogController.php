<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/4/24
 * Time: 18:38
 */

namespace app\api\controller\v1;


use app\api\controller\Api;
use app\api\model\LoginLog;
use think\exception\DbException;

class LogController extends Api
{
    /**
     * 获取登录日志
     */
    public function index() {
        try {
            $log = new LoginLog();
            $field = 'l.login_ip,l.login_area,l.login_time,l.login_status,a.admin_name';
            $data = $log->alias('l')->join('admin a', 'a.id = l.login_uid')
                ->field($field)
                ->order('login_time desc')
                ->select();
            $this->returnMsg(200, '获取完成', $data);
        } catch (DbException $e) {
            $this->returnMsg(0, $e->getMessage());
        }
    }

}
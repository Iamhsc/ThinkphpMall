<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/5/1
 * Time: 15:57
 */

namespace app\index\controller;


use app\common\model\User;
use think\exception\DbException;
use think\Request;

class UserInfoController extends BaseController
{
    /**
     * 获取个人信息
     */
    public function read()
    {
        try {
            $field = 'id,user_name as username,user_tel,user_address,user_lng, user_lat,create_time';
            $adminInfo = User::field($field)->find($this->uid);
            $this->returnMsg(200, '获取成功', $adminInfo);
        } catch (DbException $e) {
            $this->returnMsg(0, $e->getMessage());
        }
    }


    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function update(Request $request)
    {
        $data = $request->param();
        $user = new User();
        return json($user->updateUserInfo($data, $this->uid));
    }
}
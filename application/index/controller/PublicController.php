<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/5/1
 * Time: 13:03
 */

namespace app\index\controller;

use app\common\controller\Send;
use app\common\controller\Token;
use app\common\model\User;
use think\Controller;
use think\Request;
use think\Validate;

class PublicController extends Controller
{
    /**
     * 用户登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $validate = new Validate(['username' => 'require', 'password' => 'require']);
        $validate->message(['username.require' => '请输入手机号或用户名!', 'password.require' => '请输入您的密码!']);

        $param = $request->param();

        if (!$validate->check($param)) {
            Send::returnMsg(0, $validate->getError());
        }

        $where = [];
        if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $param['username'])) {
            $where['user_tel'] = $param['username'];
        } else {
            $where['user_name'] = $param['username'];
        }
        $model = new User();
        $info = $model->get($where);
        if (!$info) Send::returnMsg(0, '用户不存在');
        if ($info['user_status'] === 0) {
            Send::returnMsg(0, '账号不可用');
        }

        if (!password_verify(md5($param['password']), $info['user_pwd'])) {
            Send::returnMsg(0, '密码不正确');
        }

        $info = [
            'uid' => $info['id'],
            'username' => $info['user_name'],
            'user_tel' => $info['user_tel'],
            'user_address' => $info['user_address'],
            'user_lng' => $info['user_lng'],
            'user_lat' => $info['user_lat']
        ];
        $adminToken = new Token();
        $token = $adminToken->getToken($info,'index');//生成token
        if ($token)
            Send::returnMsg(200, '登录成功', ['token' => $token, 'info' => $info]);
        Send::returnMsg(0, '登录失败');
    }
}
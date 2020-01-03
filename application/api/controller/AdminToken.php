<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/12/31
 * Time: 22:49
 */

namespace app\api\controller;

use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use think\facade\Cache;
use think\facade\Request;

class AdminToken
{
    /**
     * 生成token
     * @param $info
     * @return string
     */
    public function getToken($info)
    {
        $key = config('jwt.key');  //这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当    于加密中常用的 盐  salt
        $token = [
            "iss" => "",                      //签发者 可以为空
            "aud" => "",                      //面象的用户，可以为空
            "iat" => config('jwt.iat'), //签发时间
            "nbf" => config('jwt.nbf'), //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
            "exp" => config('jwt.exp'), //token 过期时间
            "uid" => $info['uid']              //user info
        ];
        $jwt = JWT::encode($token, $key); //根据参数生成了 token
        // 使用Redis缓存token
        $info['token'] = $jwt;
        $cache = Cache::store('redis')->set('admin_info_' . $info['uid'], $info, 24 * 3600);
        if ($cache)
            return $jwt;
        return Send::returnMsg('400', '错误，请重试');
    }

    /**
     * 验证token
     * @return array
     */
    public function checkToken()
    {
        try {
            $token = Request::header('authorization');
            $key = config('jwt.key');
            $info = JWT::decode($token, $key, ["HS256"]);
            $admin_info = Cache::store('redis')->get('admin_info_' . $info->uid);
            if ($token !== $admin_info['token'])
                throw new SignatureInvalidException('Signature verification failed');
            unset($admin_info['token']);
            return ['code' => true, 'data' => $admin_info];
        } catch (\Exception $e) {
            return ['code' => false, 'data' => 'Invalid authorization credentials:' . $e->getMessage()];
        }
    }
}
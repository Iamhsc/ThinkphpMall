<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/12/31
 * Time: 22:49
 */

namespace app\common\controller;

use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use think\facade\Request;

class Token
{
    /**
     * 生成token
     * @param $info
     * @param $module
     * @return bool|string
     */
    public function getToken($info, $module)
    {
        $key = config('jwt.key').$module;  //这里是自定义的一个随机字串，在config文件中的，解密时也会用，
        $token = [
            "iss" => "",                      //签发者 可以为空
            "aud" => "",                      //面象的用户，可以为空
            "iat" => config('jwt.iat'), //签发时间
            "nbf" => config('jwt.nbf'), //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
            "exp" => config('jwt.exp'), //token 过期时间
            "info" => $info
        ];
        $jwt = JWT::encode($token, $key); //根据参数生成了 token
        if ($jwt)
            return $jwt;
        return false;
    }

    /**
     * 验证token
     * @return array
     */
    public function checkToken()
    {
        try {
            $token = Request::header('authorization');
            $key = config('jwt.key').Request::module();
            $check = JWT::decode($token, $key, ["HS256"]);
            if (!$check)
                throw new SignatureInvalidException('Signature verification failed'.$check->module);

            return ['code' => true, 'data' => $check->info];
        } catch (\Exception $e) {
            return ['code' => false, 'data' => 'Invalid authorization credentials:' . $e->getMessage()];
        }
    }
}

<?php
/**
 * JWT配置文件
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/12/31
 * Time: 22:51
 */
return [
    'key' => 'callmehsc',  //key
    'iss' => '',  //签发者 可以为空
    'aud' => '',  //面象的用户，可以为空
    'iat' => time(), //签发时间
    'nbf' => time(), //生效时间
    'exp' => time() + 24 * 3600 //过期时间
];
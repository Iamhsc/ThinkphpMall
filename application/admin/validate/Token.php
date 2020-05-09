<?php
namespace app\admin\validate;

use think\Validate;
/**
 * 生成token参数验证器
 */
class Token extends Validate
{
	
	protected $rule = [
        'appid'       =>  'require',
        'username'      => 'require',
        'timestamp'   =>  'number|require',
        'sign'        =>  'require'
    ];

    protected $message  =   [
        'appid.require'    => 'appid不能为空',
        'timestamp.number' => '时间戳格式错误',
        'sign.require'     => '签名不能为空',    
    ];
}
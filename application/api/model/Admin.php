<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/12/30
 * Time: 23:30
 */

namespace app\api\model;


use think\Model;

class Admin extends Model
{
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 格式化最后登录时间
    public function getLastLoginTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
    }

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
}
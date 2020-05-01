<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/4/28
 * Time: 0:00
 */

namespace app\api\model;


use think\Model;

class User extends Model
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
}
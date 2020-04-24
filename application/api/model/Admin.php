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

    // 获取最后登陆ip
    public function setLastLoginIpAttr($value)
    {
        return get_client_ip();
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

    public function updateAdmin($data,$id){
        if (isset($data['password'])) {
            if (!empty($data['password'])){
                $data['admin_password'] = password_hash(trim(md5($data['password'])), PASSWORD_DEFAULT);
            }
        }

        if (isset($data['role_id'])) {
            if (empty(Role::get($data['role_id'])))
                return [0,'角色不存在'];
        }
        if (isset($data['mobile'])) {
            $res = $this->where('mobile', 'eq', $data['mobile'])->field('id')->find();
            if ($res && $res['id'] != $id)
                return [0,'此手机号码已注册'.$res['id'].'ss'.''.$id];
        }
        if (isset($data['username'])) {
            $data['admin_name'] = $data['username'];
            unset($data['username']);
        }

        if (!$this->update($data, ['id' => $id])) {
            return [0,'更新失败'];
        }
    }

}
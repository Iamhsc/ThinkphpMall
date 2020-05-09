<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/4/28
 * Time: 0:01
 */

namespace app\common\model;


use think\Exception;
use think\Model;

class Merchant extends Model
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

    /**
     * @param $data
     * @param $id
     * @return array
     */
    public function updateMerchantInfo($data, $id)
    {
        try {
            if (isset($data['password'])) {
                if (!empty($data['password'])) {
                    $data['m_login_pwd'] = password_hash(trim(md5($data['password'])), PASSWORD_DEFAULT);
                    unset($data['password']);
                }
            }
            if (isset($data['m_tel'])) {
                $res = $this->where('m_tel', 'eq', $data['m_tel'])->field('id')->find();
                if ($res && $res['id'] != $id)
                    return ['code' => 0, 'msg' => '该手机号码已存在'];
            }
            if (isset($data['username'])) {
                $data['m_login_name_name'] = $data['username'];
                unset($data['username']);
            }

            if (!$this->update($data, ['id' => $id])) {
                return ['code' => 0, 'msg' => '更新失败'];
            }
            return ['code' => 200, 'msg' => '更新成功'];
        } catch (Exception $e) {
            return ['code' => 0, 'msg' => '更新失败' . $e->getMessage()];
        }
    }
}

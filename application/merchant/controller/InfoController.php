<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/5/1
 * Time: 15:57
 */

namespace app\merchant\controller;


use app\common\model\Merchant;
use think\exception\DbException;
use think\Request;

class InfoController extends BaseController
{
    /**
     * 获取个人信息
     */
    public function read()
    {
        try {
            $field = 'id,m_login_name as username,m_tel,m_address,m_lng, m_lat,create_time';
            $adminInfo = Merchant::field($field)->find($this->mid);
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
        $mname = $this->merchantInfo->username;
        if (!empty($mname)&&$mname!=$data['username']){
            return json(['code'=>0,'msg'=>'用户名不能更改']);
        }
        $data['m_name'] = $data['name'];
        unset($data['name']);
        $user = new Merchant();
        return json($user->updateMerchantInfo($data, $this->mid));
    }
}

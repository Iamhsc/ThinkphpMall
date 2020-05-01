<?php
/**
 * 商家管理
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/4/27
 * Time: 23:57
 */

namespace app\api\controller\v1;


use app\api\controller\Api;
use app\api\model\Merchant;
use think\exception\DbException;
use think\Request;
use think\Validate;

class MerchantController extends Api
{
    /**
     * 获取商户列表
     */
    public function index()
    {
        try {
            $where = $data = [];
            $pagenum = $this->request->param('pagenum', 1);
            $pagesize = $this->request->param('pagesize', 15);
            $keyword = $this->request->param('query');
            $where[] = ['is_delete', 'eq', 0];
            if ($keyword) {
                $where[] = ['m_login_name', 'like', "%{$keyword}%"];
            }
            $field = 'id,m_login_name,m_name,m_address,m_tel,m_status';
            $m = new Merchant();
            $data['data'] = $m->page($pagenum)->limit($pagesize)->where($where)->field($field)->select();
            $data['count'] = $m->where($where)->count('id');
            $this->returnMsg(200, '获取列表完成', $data);
        } catch (DbException $e) {
            $this->returnMsg(0, $e->getMessage());
        }
    }

    /**
     * 获取商户详情
     * @param $id
     * @throws DbException
     */
    public function read($id)
    {
        $adminInfo = Merchant::where('is_delete', 'eq', 0)->get($id);
        $this->returnMsg(200, '获取数据成功', $adminInfo);
    }

    /**
     * 添加商户
     * @param Request $request
     */
    public function save(Request $request)
    {
        $data = $request->post();

        $validate = new Validate(['m_tel' => 'require', 'password' => 'require', 'm_name' => 'require']);
        $validate->message(['m_tel.require' => '请输入手机号!', 'm_login_name.require' => '请输入密码!','m_name'=>'请输入店铺名']);
        if (!$validate->check($data)) {
            $this->returnMsg(0, $validate->getError());
        }


        if (Merchant::where('m_tel', 'eq', $data['m_tel'])->count() > 0)
            $this->returnMsg(0, '该手机号码已存在');

        $data['m_login_pwd'] = password_hash(trim(md5($data['password'])), PASSWORD_DEFAULT);

        if (!Merchant::create($data)) {
            $this->returnMsg(0, '添加失败');
        }

        $this->returnMsg(200, '添加成功');
    }

    /**
     * 更新商户信息
     * @param Request $request
     * @param $id
     * @return array
     * @throws DbException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function update(Request $request, $id)
    {
        $data = $request->post();
        $user = new Merchant();
        if (isset($data['password'])) {
            if (!empty($data['password'])) {
                $data['m_login_name'] = password_hash(trim(md5($data['password'])), PASSWORD_DEFAULT);
                unset($data['password']);
            }
        }

        if (isset($data['m_tel'])) {
            $res = $user->where('m_tel', 'eq', $data['m_tel'])->field('id')->find();
            if ($res && $res['id'] != $id)
                return [0, '该手机号码已存在'];
        }
        if (isset($data['username'])) {
            $data['m_login_name'] = $data['username'];
            unset($data['username']);
        }

        if (!Merchant::update($data, ['id' => $id])) {
            return [0, '更新失败'];
        }
        $this->returnMsg(200, '更新成功');
    }

    /**
     * 软删除指定商户
     * @param $id
     */
    public function delete($id)
    {
        try {
            if (Merchant::update(['is_delete' => 1, 'id' => $id])) {
                $this->returnMsg(200, '删除成功');
            }
            $this->returnMsg(0, '删除失败');
        } catch (\Exception $e) {
            $this->returnMsg(0, '删除失败' . $e->getMessage());
        }
    }
}

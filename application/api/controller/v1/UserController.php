<?php
/**
 * 用户管理
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/4/27
 * Time: 23:56
 */

namespace app\api\controller\v1;


use app\api\controller\Api;
use app\api\model\User;
use think\exception\DbException;
use think\Request;
use think\Validate;

class UserController extends Api
{
    /**
     * 获取用户列表
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
                $where[] = ['user_name', 'like', "%{$keyword}%"];
            }
            $user = new User();

            $field = 'id, user_name, user_tel, user_address, user_status, create_time';

            $data['data'] = $user->page($pagenum)->limit($pagesize)->where($where)->field($field)->select();
            $data['count'] = $user->where($where)->count('id');
            $this->returnMsg(200, '获取列表完成', $data);
        } catch (DbException $e) {
            $this->returnMsg(0, $e->getMessage());
        }
    }

    /**
     * 获取用户详情
     * @param $id
     * @throws DbException
     */
    public function read($id)
    {
        $adminInfo = User::where('is_delete', 'eq', 0)->get($id);
        $this->returnMsg(200, '获取数据成功', $adminInfo);
    }

    /**
     * 添加用户
     * @param Request $request
     */
    public function save(Request $request)
    {
        $data = $request->post();

        $validate = new Validate(['user_tel' => 'require', 'password' => 'require']);
        $validate->message(['user_tel.require' => '请输入手机号!', 'password.require' => '请输入密码!']);
        if (!$validate->check($data)) {
            $this->returnMsg(0, $validate->getError());
        }


        if (User::where('user_tel', 'eq', $data['user_tel'])->count() > 0)
            $this->returnMsg(0, '该手机号码已存在');

        $data['user_pwd'] = password_hash(trim(md5($data['password'])), PASSWORD_DEFAULT);

        if (!User::create($data)) {
            $this->returnMsg(0, '添加失败');
        }

        $this->returnMsg(200, '添加成功');
    }

    /**
     * 更新用户
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
        $user = new User();
        if (isset($data['password'])) {
            if (!empty($data['password'])) {
                $data['user_pwd'] = password_hash(trim(md5($data['password'])), PASSWORD_DEFAULT);
                unset($data['password']);
            }
        }

        if (isset($data['user_tel'])) {
            $res = $user->where('user_tel', 'eq', $data['user_tel'])->field('id')->find();
            if ($res && $res['id'] != $id)
                return [0, '该手机号码已存在'];
        }
        if (isset($data['username'])) {
            $data['user_name'] = $data['username'];
            unset($data['username']);
        }

        if (!User::update($data, ['id' => $id])) {
            return [0, '更新失败'];
        }
        $this->returnMsg(200, '更新成功');
    }

    /**
     * 软删除指定用户
     * @param $id
     */
    public function delete($id)
    {
        try {
            if (User::update(['is_delete' => 1, 'id' => $id])) {
                $this->returnMsg(200, '删除成功');
            }
            $this->returnMsg(0, '删除失败');
        } catch (\Exception $e) {
            $this->returnMsg(0, '删除失败' . $e->getMessage());
        }
    }
}
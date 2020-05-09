<?php
/**
 * 用户管理
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/4/27
 * Time: 23:56
 */

namespace app\admin\controller\v1;


use app\admin\controller\BaseController;
use app\common\model\User;
use Couchbase\Exception;
use think\exception\DbException;
use think\Request;
use think\Validate;

class UserController extends BaseController
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
     * @return \think\response\Json
     */
    public function save(Request $request)
    {
        $data = $request->post();

        $validate = new Validate(['user_tel' => 'require', 'password' => 'require']);
        $validate->message(['user_tel.require' => '请输入手机号!', 'password.require' => '请输入密码!']);
        if (!$validate->check($data)) {
            $this->returnMsg(0, $validate->getError());
        }
        $user = new User();
        return json($user->addUser($data));
    }

    /**
     * 更新用户
     * @param Request $request
     * @param $id
     * @return \think\response\Json
     */
    public function update(Request $request, $id)
    {
        $data = $request->post();
        $user = new User();
        return json($user->updateUserInfo($data,$id));
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
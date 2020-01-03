<?php

namespace app\api\controller\v1;

use app\api\controller\AdminToken;
use app\api\model\Admin;
use app\api\model\Menu;
use app\api\model\Role;
use think\Request;
use app\api\controller\Api;
use think\Validate;

class AdminController extends Api
{
    /**
     * 不需要鉴权方法
     * index、save不需要鉴权
     * ['index','save']
     * 所有方法都不需要鉴权
     * [*]
     */
    protected $noAuth = ['login'];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $where = $data = [];
        $page = $this->request->param('page/d', 1);
        $limit = $this->request->param('limit/d', 15);
        $keyword = $this->request->param('keyword/s');
        $where[] = ['id', 'neq', 1];
        if ($keyword) {
            $where[] = ['admin_name', 'like', "%{$keyword}%"];
        }

        $field = 'id,role_id,admin_name,nickname,mobile,email,status,last_login_ip,last_login_time,create_time';
        $data['data'] = Admin::where($where)->page($page)->limit($limit)->field($field)->select();
        $data['count'] = count($data['data']);

        $this->returnMsg(200, '获取index', $data);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $info = $request->param();
        $this->returnMsg(200, '保存', ['request' => $info]);
    }

    /**
     * 显示指定的资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        $tree=Menu::getAllChild($this->uid);
        $this->returnMsg(200, '1读取read', ['id' => $id, 'param' => $tree]);
    }

    /**
     * 更新资源 put请求
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $this->returnMsg(200, '更新成功', ['request' => $request, 'id' => $id, 'param' => $request->param()]);
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $this->returnMsg(200, '删除成功', ['token' => 'sdasdsadsdas', 'param' => $id]);
    }


    public function address($id)
    {
        echo "address-";
        echo $id;
    }

    /**
     * 用户登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $validate = new Validate(['username' => 'require', 'password' => 'require']);
        $validate->message(['username.require' => '请输入手机号,邮箱或用户名!', 'password.require' => '请输入您的密码!']);

        $param = $request->param();

        if (!$validate->check($param)) {
            $this->returnMsg('400', $validate->getError());
        }

        $where = [];
        if ($validate->is($param['username'], 'email')) {
            $where['email'] = $param['username'];
        } else if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $param['username'])) {
            $where['mobile'] = $param['username'];
        } else {
            $where['admin_name'] = $param['username'];
        }
        $model = new Admin();
        $info = $model->get($where);
        if (!$info) $this->returnMsg(0, '用户不存在');
        if ($info['status'] === 0) $this->returnMsg(0, '您已被拉黑');
        if (!password_verify(md5($param['password']), $info['admin_password']))$this->returnMsg(0, '密码不正确');

        $ip = get_client_ip($type = 0, $adv = false);
        $up['last_login_ip'] = $ip;
        $up['last_login_time'] = time();
        $updateUser = $model->save($up, ['id' => $info['id']]);

        if ($updateUser === 0) {
            $this->returnMsg(0, "登录失败!");
        }
        $info = [
            'uid' => $info['id'],
            'role_id'=>$info['role_id'],
            'username' => $info['admin_name'],
            'nickname' => $info['nickname'],
            'mobile' => $info['mobile'],
            'email' => $info['email'],
            'last_login_ip' => $info['last_login_ip'],
            'last_login_time' => $info['last_login_time'],
        ];
        $adminToken = new AdminToken();
        $token = $adminToken->getToken($info);//生成token

        $this->returnMsg(200, '登录成功',  ['token' => $token, 'info' => $info]);
    }
}

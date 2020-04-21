<?php

namespace app\api\controller\v1;

use app\api\controller\Api;
use app\api\model\Role;
use think\exception\DbException;
use think\Request;
use think\Validate;

class RoleController extends Api
{
    /**
     * 获取角色列表
     */
    public function index()
    {
        try {
            $where = $data = [];
            $pagenum = $this->request->param('pagenum', 1);
            $pagesize = $this->request->param('pagesize', 10);
            $keyword = $this->request->param('query');
            if ($keyword) {
                $where[] = ['name', 'like', "%{$keyword}%"];
            }
            $data['data'] = Role::where($where)->page($pagenum)->limit($pagesize)->select();
            $data['count'] = Role::where($where)->count('id');
            $this->returnMsg(200, '角色列表完成', $data);
        } catch (DbException $e) {
            $this->returnMsg(400, $e->getMessage());
        }
    }


    /**
     * 获取指定角色
     * @param $id
     */
    public function read($id)
    {
        try {
            $adminInfo = Role::get($id);
            $this->returnMsg(200, '获取数据成功', $adminInfo);
        } catch (DbException $e) {
            $this->returnMsg(400, $e->getMessage());
        }
    }

    /**
     * 新建角色
     * @param Request $request
     */
    public function save(Request $request)
    {
        $data = $request->post();
        $validate = new Validate(['name' => 'require']);
        $validate->message(['name.require' => '请输入角色名!']);

        if (isset($data['id'])){
            $this->update($request,$data['id']);
        }

        if (!Role::create($data)) {
            $this->returnMsg(0, '添加角色失败');
        }

        $this->returnMsg(200, '添加角色成功');
    }

    /**
     * 更新角色
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        if (!Role::update($request->post(),['id'=>$id])){
            $this->returnMsg(0, '更新角色失败');
        }
        $this->returnMsg(200, '更新角色成功');
    }

    /**
     * 删除角色
     * @param $id
     */
    public function delete($id)
    {
        try {
            if (Role::where(['id' => $id])->delete()) {
                $this->returnMsg('200', '删除成功');
            }
            $this->returnMsg('400', '删除失败');
        } catch (\Exception $e) {
            $this->returnMsg('400', '删除失败' . $e->getMessage());
        }
    }
}

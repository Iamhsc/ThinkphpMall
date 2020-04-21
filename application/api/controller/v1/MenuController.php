<?php

namespace app\api\controller\v1;

use app\api\controller\Api;
use app\api\model\Menu;
use think\Request;
use think\Validate;

class MenuController extends Api
{
    /**
     *
     * 获取菜单
     */
    public function index()
    {
        $tree=Menu::getAllChildMenu();
        $this->returnMsg(200, '获取菜单成功', $tree);
    }

    /**
     * 添加菜单
     * @param Request $request
     */
    public function save(Request $request)
    {
        $data = $request->post();

        $validate = new Validate(['title' => 'require', 'ctrl' => 'require', 'action' => 'require']);
        $validate->message(['title.require' => '请输入菜单名!', 'ctrl.require' => '控制名不能为空!', 'action.require' => '方法名不能为空']);

        if (!$validate->check($data)) {
            $this->returnMsg(0, $validate->getError());
        }

        if (Menu::where('id','eq',$data['pid'])->count('id') < 1 && $data['pid'] != 0)
            $this->returnMsg(0, '上级菜单不存在');

        if (!Menu::create($data)) {
            $this->returnMsg(0, '添加菜单失败');
        }

        $this->returnMsg(200, '添加菜单成功');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->post();

        $validate = new Validate(['title' => 'require', 'ctrl' => 'require', 'action' => 'require']);
        $validate->message(['title.require' => '请输入菜单名!', 'ctrl.require' => '控制名不能为空!', 'action.require' => '方法名不能为空']);

        if (!$validate->check($data)) {
            $this->returnMsg(0, $validate->getError());
        }

        if (Menu::where('pid','eq',$data['pid'])->count('id') < 1)
            $this->returnMsg(0, '父节点不存在');

        if (!Menu::update($data,['id'=>$id])) {
            $this->returnMsg(0, '更新菜单失败');
        }

        $this->returnMsg(200, '更新菜单成功');
    }

    /**
     * 删除菜单
     * @param $id
     */
    public function delete($id)
    {
        try {
            if (Menu::where(['id' => $id, 'system' => 0])->delete()) {
                $this->returnMsg(200, '删除成功');
            }
            $this->returnMsg(0, '删除失败');
        } catch (\Exception $e) {
            $this->returnMsg(0, '删除失败' . $e->getMessage());
        }
    }
}

<?php

namespace app\api\controller\v1;

use app\api\controller\Api;
use app\api\model\Menu;
use think\Request;

class AuthController extends Api
{
    /**
     *
     * 获取菜单
     */
    public function index()
    {
        $tree=Menu::getAuthChildMenu($this->uid);
        $this->returnMsg(200, '获取成功', $tree);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $auth = [];
        $auth = Menu::getRoleAuthChildMenu($id);
        $this->returnMsg(200, '获取成功', $auth);
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
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}

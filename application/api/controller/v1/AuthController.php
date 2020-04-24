<?php

namespace app\api\controller\v1;

use app\api\controller\Api;
use app\api\model\Menu;
use app\api\model\RoleAuth;
use think\Exception;
use think\Request;

class AuthController extends Api
{
//    protected $noAuth = ['index'];
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
     * 获取指定角色权限
     * @param $id
     */
    public function read($id)
    {
        try{
            $auth = Menu::getRoleAuthChildMenu($id);
            $this->returnMsg(200, '获取成功', $auth);
        }
        catch (\Exception $e){
            $this->returnMsg(00, '获取失败', $e);
        }
    }


    public function update(Request $request, $id)
    {
        $rids= $request->post();
        try{
            RoleAuth::where(['role_id'=>$id])->delete();
            foreach ($rids['rids'] as $item) {
                if (!RoleAuth::create(['role_id'=>$id,'auth_id'=>$item]))
                    $this->returnMsg(0,'分配失败');
            }
            $this->returnMsg(200, '分配成功');
        }catch (\Exception $e){
            $this->returnMsg(0,'分配失败',$e);
        }
    }
}

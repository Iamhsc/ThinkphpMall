<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/4/24
 * Time: 20:59
 */

namespace app\admin\controller\v1;


use app\admin\controller\BaseController;
use app\admin\model\Admin;
use think\Request;

class IndexController extends BaseController
{
    function update(Request $request){
        $admin = new Admin();
        $res = $admin->updateAdmin($request->post(), $this->aid);
        if ($res[0] === 0) $this->returnMsg(0, $res[1]);
        $this->returnMsg(200, '更新成功');
    }
}
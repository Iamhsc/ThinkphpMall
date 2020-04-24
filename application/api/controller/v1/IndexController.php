<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/4/24
 * Time: 20:59
 */

namespace app\api\controller\v1;


use app\api\controller\Api;
use app\api\model\Admin;
use think\Request;

class IndexController extends Api
{
    function update(Request $request){
        $admin = new Admin();
        $res = $admin->updateAdmin($request->post(), $this->uid);
        if ($res[0] === 0) $this->returnMsg(0, $res[1]);
        $this->returnMsg(200, '更新成功');
    }
}
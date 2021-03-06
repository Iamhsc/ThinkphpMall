<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/5/6
 * Time: 23:09
 */

namespace app\index\controller;


use app\common\model\Order;
use think\Request;

class OrderController extends BaseController
{

    function index()
    {
        $order = new Order();
        $where = ['uid' => $this->uid, 'delete_for_user' => 0];
        return json($order->getOrderList($where));
    }

    function read($id)
    {
        $order = new Order();
        return json($order->getOrderDetails($id));
    }

    function update(Request $request, $id)
    {
        $order = new Order();
        $data = $request->post();
        $res = $order->update($data, ['id' => $id]);
        if ($res)
            $this->returnMsg(200, 'ok');
        $this->returnMsg(200, 'ok');
    }
}

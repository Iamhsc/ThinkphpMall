<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/5/1
 * Time: 13:44
 */

namespace app\merchant\controller;


use app\common\controller\Send;
use think\Controller;
use think\Request;

class BaseController extends Controller
{
    use Send;
    protected $request;

    protected $mid;

    protected $merchantInfo = [];

    /**
     * 不需要鉴权方法
     */
    protected $noAuth = [];

    /**
     * 构造方法
     * @param Request $request Request对象
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->init();
    }

    /**
     * 初始化
     * 检查请求类型，数据格式等
     */
    public function init()
    {
        //所有ajax请求的options预请求都会直接返回200，如果需要单独针对某个类中的方法，可以在路由规则中进行配置
        if ($this->request->isOptions()) $this->returnMsg(200, 'success');

        $adminToken = new \app\common\controller\Token();
        $check = $adminToken->checkToken();           //检查token是否正确
        if (!$check['code'])                          //如果token不正确
            $this->returnMsg(401, $check['data']);

        $this->merchantInfo = $check['data'];             //管理员信息
        $this->mid = $check['data']->mid;           //管理员id
    }
}

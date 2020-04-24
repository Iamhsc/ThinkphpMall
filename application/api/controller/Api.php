<?php

namespace app\api\controller;

use app\api\model\Menu;
use app\api\model\Role;
use think\Request;

/**
 * api 入口文件基类，需要控制权限的控制器都应该继承该类
 */
class Api
{
    use Send;
    /**
     * @var \think\Request Request实例
     */
    protected $request;

    protected $uid;

    protected $userInfo = [];

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
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:*');
        //所有ajax请求的options预请求都会直接返回200，如果需要单独针对某个类中的方法，可以在路由规则中进行配置
        if ($this->request->isOptions()) self::returnMsg(200, 'success');

        if (!Oauth::match($this->noAuth)) {               //请求方法白名单
            $adminToken = new AdminToken();
            $check = $adminToken->checkToken();           //检查token是否正确
            if (!$check['code'])                          //如果token不正确
                self::returnMsg(401, $check['data']);

            $this->userInfo = $check['data'];             //管理员信息
            $this->uid = $check['data']->uid;           //管理员id
            $menuInfo = Menu::getMenuInfo($this->request);      //当前访问节点id
            if ($menuInfo['url'] != 'auth/index'){
                if (!Role::checkAuth($this->uid, $menuInfo['menu']['id']))
                    self::returnMsg(0, '访问权限不足:'.$menuInfo['menu']['title']);
            }
        }
    }

    /**
     * 空方法
     */
    public function _empty()
    {
        self::returnMsg(404, 'empty method!');
    }
}
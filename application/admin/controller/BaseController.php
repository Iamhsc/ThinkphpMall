<?php

namespace app\admin\controller;

use app\admin\model\Menu;
use app\admin\model\Role;
use app\common\controller\Send;
use think\Request;

/**
 * api 入口文件基类，需要控制权限的控制器都应该继承该类
 */
class BaseController
{
    use Send;
    /**
     * @var \think\Request Request实例
     */
    protected $request;

    protected $aid;

    protected $adminInfo = [];

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
        if ($this->request->isOptions()) self::returnMsg(200, 'success');

        if (!self::match($this->noAuth)) {               //请求方法白名单
            $adminToken = new \app\common\controller\Token();
            $check = $adminToken->checkToken();           //检查token是否正确
            if (!$check['code'])                          //如果token不正确
                self::returnMsg(401, $check['data']);

            $this->adminInfo = $check['data'];             //管理员信息
            $this->aid = $check['data']->uid;           //管理员id
            $menuInfo = Menu::getMenuInfo($this->request);      //当前访问节点id
            if ($menuInfo['url'] != 'auth/index'){
                if (!Role::checkAuth($this->aid, $menuInfo['menu']['id']))
                    self::returnMsg(0, '访问权限不足:'.$menuInfo['menu']['title']);
            }
        }
    }

    /**
     * 检测当前控制器和方法是否匹配传递的数组
     * @param array $arr 需要验证权限的数组
     * @return boolean
     */
    public static function match($arr = [])
    {
        $arr = is_array($arr) ? $arr : explode(',', $arr);
        if (!$arr)
        {
            return false;
        }
        $request = \think\facade\Request::instance();
        $arr = array_map('strtolower', $arr);
        // 是否存在
        if (in_array(strtolower($request->action()), $arr) || in_array('*', $arr))
        {
            return true;
        }
        // 没找到匹配
        return false;
    }

    /**
     * 空方法
     */
    public function _empty()
    {
        self::returnMsg(404, 'empty method!');
    }
}
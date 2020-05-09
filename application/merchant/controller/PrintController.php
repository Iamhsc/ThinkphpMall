<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/5/1
 * Time: 17:33
 */

namespace app\merchant\controller;


use app\common\model\File;
use app\common\model\Merchant;
use app\common\model\Options;
use app\common\model\Order;
use app\common\model\Upload;
use think\Request;

class PrintController extends BaseController
{
    /**
     * 获取商家列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {

//        $radius = $this->request->param('radius');
        $where['m_status'] = 2;
        $where['is_delete'] = 0;
        $f = 'id,m_name,m_tel,m_status,m_address,m_lng,m_lat';
//        if ($radius) {
//            $info = $this->userInfo;
//            $r = $this->calcScope($info['user_lng'], $info['user_lat'], $radius);
//            $where['m_lng'] = [['ELT', $r['maxLng']], ['EGT', $r['minLng']]];
//            $where['m_lat'] = [['ELT', $r['maxLat']], ['EGT', $r['minLat']]];
//            // 获取范围内店铺
//        }
        $this->returnMsg(200, '获取成功', Merchant::where($where)->field($f)->select());
    }

    public function upload(){
        $upload = new Upload();
        $file = request()->file('file');
        if ($file) {
            return json($upload->upload($file,$this->uid));
        }
        return ['code' => 0, 'data' => '', 'msg' => '请选择文件'];
    }

    /**
     * 获取某商家打印项目
     * @param $mid
     * @return \think\response\Json
     */
    public function get_price($mid){
        $o = new Options();
        return json($o->getPrice($mid));
    }

    /**
     * 添加打印
     * @param Request $request
     */
    public function save(Request $request){
        $data = $request->post();
        $data['uid'] = $this->uid;
        $data['file_id'] = json_encode($data['file_id'],true);
        $data['order_number'] = date('Ymd') . $this->uid . $data['mid'] . str_pad(mt_rand(1, 99999), 3, '0', STR_PAD_LEFT);
        $order = new Order();
        if ($order->save($data))
            $this->returnMsg(200,'添加成功');
        $this->returnMsg(0,'添加失败');
    }


    /**
     * 根据经纬度和半径计算出范围
     * @param $lat 纬度
     * @param $lng 经度
     * @param int $radius 半径
     * @return array
     */
    private function calcScope($lat, $lng, $radius = 3000)
    {
        $degree = (24901 * 1609) / 360.0;
        $dpmLat = 1 / $degree;

        $radiusLat = $dpmLat * $radius;
        $minLat = $lat - $radiusLat;       // 最小纬度
        $maxLat = $lat + $radiusLat;       // 最大纬度

        $mpdLng = $degree * cos($lat * (pi() / 180));
        $dpmLng = 1 / $mpdLng;
        $radiusLng = $dpmLng * $radius;
        $minLng = $lng - $radiusLng;      // 最小经度
        $maxLng = $lng + $radiusLng;      // 最大经度

        /** 返回范围数组 */
        $scope = array(
            'minLat' => $minLat,
            'maxLat' => $maxLat,
            'minLng' => $minLng,
            'maxLng' => $maxLng
        );
        return $scope;
    }
}

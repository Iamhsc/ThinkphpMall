<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/5/7
 * Time: 18:38
 */

namespace app\merchant\controller;


use app\common\model\Options;
use think\Request;

class OptionsController extends BaseController
{
    public function save(Request $request)
    {
        $data = $request->post();
        $opt = new Options();
        if ($opt->where('mid', 'eq', $this->mid)->find()){
            $opt->update($data, ['mid' => $this->mid]);
        }else{
            $data['mid'] = $this->mid;
            $opt->save($data);
        }
        if ($opt)
            $this->returnMsg(200, '成功');
        $this->returnMsg(0, '失败');
    }

    public function read()
    {
        $opt = new Options();
        $op = $opt->where('mid', 'eq', $this->mid)->field('options')->find();
        $this->returnMsg(200, '成功', $op);
    }
}

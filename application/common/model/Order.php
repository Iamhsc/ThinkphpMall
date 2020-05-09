<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/5/6
 * Time: 22:49
 */

namespace app\common\model;


use think\Exception;
use think\Model;

class Order extends Model
{
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 格式化创建时间
    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
    }

    // 格式化更新时间
    public function getUpdateTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
    }

    /**
     * @param $where
     * @return array
     */
    public function getOrderList($where)
    {
        try {
            $field = 'o.id,o.order_number,o.total_price,o.p_options as options,o.file_id,o.create_time,o.order_status,m.m_name,u.user_name';
            $orders = $this->alias('o')
                ->join('merchant m', 'o.mid=m.id')
                ->join('user u', 'o.uid=u.id')
                ->field($field)
                ->where($where)
                ->select();
            $files = [];
            foreach ($orders as $order) {
                $order['options'] = json_decode($order['options']);
                $order['file_id'] = json_decode($order['file_id'], true);

                foreach ($order['file_id'] as $item) {
                    $files[] = File::where('id', 'eq', $item)->field('file_name,file_url')->find();
                }
                $order['files'] = $files;
                $files = [];
                unset($order['file_id']);
            }
            return ['code' => 200, 'msg' => '获取成功', 'data' => $orders];
        } catch (Exception $e) {
            return ['code' => 200, 'msg' => '获取失败' . $e->getMessage()];
        }
    }

    public function getOrderDetails($id){
        try {
            $field = 'o.*,m.m_name,u.user_name';
            $order = $this->alias('o')
                ->join('merchant m', 'o.mid=m.id')
                ->join('user u', 'o.uid=u.id')
                ->field($field)
                ->where('o.id','eq',$id)
                ->find();
            $files = [];
                $order['options'] = json_decode($order['p_options']);
                $order['file_id'] = json_decode($order['file_id'], true);

                foreach ($order['file_id'] as $item) {
                    $files[] = File::where('id', 'eq', $item)->field('file_name,file_url')->find();
                }
                $order['files'] = $files;
                unset($order['file_id'],$order['p_options'],$order['uid'],$order['mid']);
            return ['code' => 200, 'msg' => '获取成功', 'data' => $order];
        } catch (Exception $e) {
            return ['code' => 200, 'msg' => '获取失败' . $e->getMessage()];
        }
    }
}

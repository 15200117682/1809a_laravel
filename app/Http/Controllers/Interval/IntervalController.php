<?php

namespace App\Http\Controllers\Interval;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntervalController extends Controller
{

    //订单超过半小时未支付，定为过期
    public function interval(){
        $time=time();
        $order=GoodsModel::where(['order_status'=>1])->select();
        foreach($order as $k=>$v){
            if($time - $v->create_time > 1800){
                GoodsModel::where(["order_id"=>$v->order_id])->update(['order_status'=>2]);
            }
        }

    }
}

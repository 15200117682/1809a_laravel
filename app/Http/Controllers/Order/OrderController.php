<?php

namespace App\Http\Controllers\Order;

use App\Model\CartModel;
use App\Model\OrderModel;
use App\Model\OrderDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function create(){
        //计算订单金额
        $goods = CartModel::where(['uid'=>Auth::id(),'session_id'=>Session::getId()])->get()->toArray();
        $order_amount = 0;
        foreach($goods as $k=>$v){
            $order_amount += $v['goods_price']; //计算金额
        }

        $order_info = [
            'uid'               => Auth::id(),
            'order_sn'          => OrderModel::generateOrderSN(Auth::id()),     //订单编号
            'order_amount'      => $order_amount,
            'order_status'         =>1,
            'order_time'          => time()
        ];

        $oid = OrderModel::insertGetId($order_info); //写入订单表

        //订单详情
        foreach($goods as $k=>$v){
            $detail = [
                'order_id'           => $oid,
                'goods_id'      => $v['goods_id'],
                'goods_name'    => $v['goods_name'],
                'goods_price'   => $v['goods_price'],
                'uid'           => Auth::id()
            ];
            //写入订单详情表
            OrderDetailModel::insertGetId($detail);
        }

        header('Refresh:3;url=/order/list');
        echo "生成订单成功";

    }

    //订单列表页
    public function list()
    {
        $list = OrderModel::where(['uid'=>Auth::id()])->orderBy("order_id","desc")->get()->toArray();
        $data = [
            'list'  => $list
        ];
        return view('order.list',$data);
    }

}

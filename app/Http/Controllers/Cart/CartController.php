<?php

namespace App\Http\Controllers\Cart;

use App\Model\CartModel;
use App\Model\GoodsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //购物车页面
    public function cart()
    {
        $cart_list = CartModel::where(['uid'=>Auth::id(),'session_id'=>Session::getId()])->get()->toArray();
        if($cart_list){
            $total_price = 0;
            foreach($cart_list as $k=>$v){
                $g = GoodsModel::where(['goods_id'=>$v['goods_id']])->first()->toArray();
                $total_price += $g['goods_price'];
                $goods_list[] = $g;
            }

            $data = [
                'goods_list' => $goods_list,
                'total'     => $total_price / 100
            ];
            return view('cart.index',$data);
        }else{
            header('Refresh:3;url=/');
            die("购物车为空,跳转至首页");
        }//展示购物车

    }

    //添加至购物车
    public function cartAdd(){
        $goods_id=$_GET['goods_id'];
        if(empty($goods_id)){
            header('Refresh:3;url=/cart/cart');
            die("请选择商品，正在跳转至购物车");
        }
        $goods = GoodsModel::where(['goods_id'=>$goods_id])->first();
        if($goods){
            if($goods->goods_status==1){       //已被删除
                header('Refresh:3;url=/');
                echo "商品已被删除，正在跳转至首页";
                die;
            }//判断商品是否有效
            $cart_info = [
                'uid'       => Auth::id(),//用户id
                'goods_id'  => $goods_id,//商品id
                'goods_name'    => $goods->goods_name,//商品名称
                'buy_num'          =>1,
                'goods_price'    => $goods->goods_price,//价格
                'session_id' => Session::getId(),
                'add_time'  => time()//添加时间

            ];//添加购物车表的数据
            $cart_id = CartModel::insertGetId($cart_info);//存入数据库
            if($cart_id){
                header('Refresh:3;url=/cart/cart');
                die("添加购物车成功，正在跳转至购物车");
            }else{
                header('Refresh:3;url=/');
                die("添加购物车失败");
            }
        }else{
            echo "商品不存在";
        }

    }

}

<?php

namespace App\Http\Controllers\Goods;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class GoodsController extends Controller
{
    public function list($goods_id){
        if(!$goods_id){
            die('错误参数');
        }
        $data=GoodsModel::where(['goods_id'=>$goods_id])->first()->toArray();//查询商品
        if($data==NULL){
            header('Refresh:3;url=/');
            die("商品不存在，自动跳转首页");
        }//查询商品是否存在

        $view=0;
        $redis_key="goods_id:$view";//存取游览次数
        $view=Redis::incr($redis_key);    //每次运行添加游览商品的次数


        $info=[
            "goods"=>$data,
            'view'=>$view
        ];//要传到试图的数据

        return view('goods.list',$info);//返回
    }

    public function cacheGoods($goods_id){
        $goods_id=intval($goods_id);//改为int类型的数据
        $redis_cache_goods_key='h:goods_id'.$goods_id;//给定哈希key值
        $cache_info=Redis::hGetAll($redis_cache_goods_key);//存入哈希数据

        if($cache_info){//如果有值打印值
            print_r($cache_info);
        }else{//如果没值存入redis缓存
            $goods_info=GoodsModel::where(['goods_id'=>$goods_id])->first()->toArray();
            Redis::hMset($redis_cache_goods_key,$goods_info);
        }

    }

}

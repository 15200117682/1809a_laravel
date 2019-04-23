<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use vendor\project\StatusTest;

class JssdkController extends Controller
{
    public function jsTest(){

        //计算签名
        $nonceStr = Str::random(10);
        $ticket = getJsapiTicket();
        $timestamp = time();
        $current_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'];

        $string1 = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$current_url";
        $sign = sha1($string1);     //生成签名

        $js_config=[
            'appId'     =>env('WX_APPID'),      //公众号APPID
            'timestamp' =>$timestamp,               //时间
            'nonceStr'  =>$nonceStr,            //随机字符串
            'signature' =>$sign,                //签名
        ];

        $data=[
            'jsconfig'=>$js_config
        ];//写入数组

        return view("weixin.jssdk",$data);
    }

    
    public function getImg()
    {
        echo '<pre>';print_r($_GET);echo '</pre>';
    }
}

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/info",function (){
    phpinfo();
});//查看php配置


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');//用户

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');//用户

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');//用户



//购物车
Route::get("/cart/cart","Cart\CartController@cart");//购物车首页
Route::get("/cart/cartAdd","Cart\CartController@cartAdd");//购物车添加

//订单
Route::get("/order/create","Order\OrderController@create");//生成订单
Route::get("/order/list","Order\OrderController@list");//生成订单

//微信支付
Route::get('/pay/weixin', 'Wechat\PayController@pay');      //微信支付

//商品
Route::get('/goods/list/{goods_id?}', 'Goods\GoodsController@list');      //商品展示
Route::get('/goods/cachegoods/{goods_id?}', 'Goods\GoodsController@cacheGoods');      //商品缓存

//微信sdk
Route::get("/wx/js/test","Wechat\JssdkController@jsTest");  //jssdk测试


<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource("/goods",GoodsController::class);//商品管理
    $router->resource("/users",UserController::class);//用户管理
    $router->resource("/sucai/add",SucaiController::class);//添加素材
});

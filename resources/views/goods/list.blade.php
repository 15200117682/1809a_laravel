@extends('layouts.app')
@section('content')
        <div class ='container'>
            <div class="col-md-8">
                <div class  ='card'>
                    <div class="card-body">
                                {{$goods['goods_name']}}-{{$goods['goods_price']}}<br>
                                商品游览次数：{{$view}}
                    </div>
                </div>
            </div>
        </div>
@endsection
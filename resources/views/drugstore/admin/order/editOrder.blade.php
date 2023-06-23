@php
// dd($order->deli_status)
@endphp
@extends('drugstore.app')

@section('title', '注文編集')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
@endsection

@section('header')
@if (Auth::user()->permission_id == 1)
@include('drugstore.header.adminHeader')
@else
@include('drugstore.header.producerHeader')
@endif
@endsection

@section('main-content')
<div class="app-container">
    <div class="user__table-wrap">
        <h2>注文編集</h2>
        @if (Auth::user()->permission_id == 1)
        <form action="{{route('order.update',['order' => $order->id])}}" method="POST">
        @else
        <form action="{{route('producer.orderUpdate',['id' => $order->id])}}" method="POST">
        @endif
            @csrf
            @method('PUT')
            <div class="avatar" style="border-radius: 0;">
                <img src="{{ asset('img/product_img/' . $order->product->image) }}" alt="image">
            </div>
            <div class="info">
                <ul class="info-list">
                    <li class="info-list__item">
                        <div class="infor-list__key">名前:</div>
                        <div class="infor-list__value">
                            <span>{{$order->product->name}}</span>                         
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">数量</div>
                        <div class="infor-list__value">
                            <span>{{$order->quantity}}</span>
                        </div>
                    </li>
                    @if (auth()->user()->permission_id === 1)
                    <li class="info-list__item">
                        <div class="infor-list__key">ユーザー:</div>
                        <div class="infor-list__value">
                            <span>{{$order->user->name}}</span>
                        </div>
                    </li>    
                    @endif
                    
                    <li class="info-list__item">
                        <div class="infor-list__key">価格:</div>
                        <div class="infor-list__value">
                            <span>{{$order->total_money}}円</span>
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">住所:</div>
                        @if (Auth::user()->permission_id == 1)
                        <div class="infor-list__value">
                            @if (old('address'))
                            <input name="address" type="text" value="{{old('address')}}">
                            @else
                            <input name="address" type="text" value="{{$order->to_address}}">
                            @endif
                            @if($errors->has('address'))
                            <span class="form-message error">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                        @else
                        <div class="infor-list__value">
                            <input name="address" type="hidden" value="{{$order->to_address}}">
                            <span class="">{{$order->to_address}}</span>
                        </div>
                        @endif
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">電話番号:</div>
                        @if (Auth::user()->permission_id == 1)
                        <div class="infor-list__value">
                            @if (old('phone'))
                            <input name="phone" type="text" value="{{old('phone')}}">
                            @else
                            <input name="phone" type="text" value="{{$order->phone}}">
                            @endif
                            @if($errors->has('phone'))
                            <span class="form-message error">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        @else
                        <div class="infor-list__value">
                            <input name="phone" type="hidden" value="{{$order->phone}}">
                            <span class="">{{$order->phone}}</span>
                        </div>
                        @endif
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">メールアドレス:</div>
                        @if (Auth::user()->permission_id == 1)
                        <div class="infor-list__value">
                            @if (old('email'))
                            <input name="email" type="text" value="{{old('email')}}">
                            @else
                            <input name="email" type="text" value="{{$order->email}}">
                            @endif
                            @if($errors->has('email'))
                            <span class="form-message error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        @else
                        <div class="infor-list__value">
                            <input name="email" type="hidden" value="{{$order->email}}">
                            <span class="">{{$order->email}}</span>
                        </div>
                        @endif
                    </li>
                    <li class="info-list__item">
                        <label for="deli_status" class="infor-list__key">配達状況</label>
                        <select name="deli_status" id="deli_status" >
                            @if (old('deli_status'))
                            <option value="準備中" {{old('deli_status')=='準備中'?'selected':''}}>
                                準備中</option>
                            <option value="配達中" {{old('deli_status')=='配達中'?'selected':''}}>
                                配達中</option>
                            <option value="配達完了" {{old('deli_status')=='配達完了'?'selected':''}}>
                                配達完了</option>
                            @else
                            <option value="準備中">準備中</option>
                            <option value="配達中">配達中</option>
                            <option value="配達完了">配達完了</option>
                            <input type="hidden" value="{{$order->deli_status}}" id="forDelivery">
                            @endif
                        </select>
                    </li>
                    <input type="hidden" name="pay" value="{{$order->pay_by}}">  
                    <input type="hidden" name="product_id" value="{{$order->product_id}}">  
                </ul>
            </div>
            <div class="action">
                <div class="edit">
                    @if (Auth::user()->permission_id == 1)
                    <a href="{{route('order.show', ['order' => $order->id])}}">戻る</a>
                    @else
                    <a href="{{route('producer.orderShow', ['id' => $order->id])}}">戻る</a>
                    @endif
                </div>
                <div class="delete">
                    <button type="submit">確認</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
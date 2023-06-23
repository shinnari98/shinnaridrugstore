@php
    // dd($order->id);
@endphp
@extends('drugstore.app')

@section('title', '注文編集')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
@endsection

@section('header')
@include('drugstore.header.userHeader')
@endsection

@section('main-content')
<div class="app-container">
    <div class="user__table-wrap">
        <h2>注文編集</h2>
        <form action="{{route('order.userUpadate')}}" method="POST">
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
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">電話番号:</div>
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
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">メールアドレス:</div>
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
                    </li>
                    <input type="hidden" name="pay" value="{{$order->pay_by}}">  
                    <input type="hidden" name="id" value="{{$order->id}}">  
                </ul>
            </div>
            <div class="action">
                <div class="edit">
                    <a href="{{route('user.showOrder')}}">戻る</a>
                </div>
                <div class="delete">
                    <button type="submit">確認</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
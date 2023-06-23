@extends('drugstore.app')

@section('title', '商品新規作成')

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
        <h2>商品新規作成</h2>
        @if (Auth::user()->permission_id == 1)
        <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
        @else
        <form action="{{route('producer.productStore')}}" method="POST" enctype="multipart/form-data">
        @endif
            @csrf
            @method('POST')
            <div class="avatar">
                <i class="user-icon fa-solid fa-circle-user"></i>
                <input type="file" id="file" name="image" class="avatar-upfile">
                @if($errors->has('image'))
                <span class="form-message error">{{ $errors->first('image') }}</span>
                @endif
            </div>
            <div class="info">
                <ul class="info-list">
                    <li class="info-list__item">
                        <div class="infor-list__key">名前:</div>
                        <div class="infor-list__value">
                            <input name="name" type="text" value="{{ old('name') }}">
                            @if($errors->has('name'))
                            <span class="form-message error">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </li>
            
                    <li class="info-list__item">
                        <div class="infor-list__key">カテゴリーID:</div>
                        <div class="infor-list__value">
                            <input name="category_id" type="text" value="{{ old('category_id') }}">
                            @if($errors->has('category_id'))
                            <span class="form-message error">{{ $errors->first('category_id') }}</span>
                            @endif
                        </div>
                    </li>
                    @if ($user->permission_id === 1)
                    <li class="info-list__item">
                        <div class="infor-list__key">サプライヤーID:</div>
                        <div class="infor-list__value">
                            <input name="producer_id" type="text" value="{{old('producer_id')}}">
                            @if($errors->has('producer_id'))
                            <span class="form-message error">{{ $errors->first('producer_id') }}</span>
                            @endif
                        </div>
                    </li>    
                    @endif
                    
                    <li class="info-list__item">
                        <div class="infor-list__key">価格:</div>
                        <div class="infor-list__value">
                            <input name="price" type="text" value="{{old('price')}}">
                            @if($errors->has('price'))
                            <span class="form-message error">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">割引:</div>
                        <div class="infor-list__value">
                            <input name="sale_off" type="text" value="{{old('sale_off')}}">
                            @if($errors->has('sale_off'))
                            <span class="form-message error">{{ $errors->first('sale_off') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">インフォメーション:</div>
                        <div class="infor-list__value">
                            {{-- <input name="" type="text" value=> --}}
                            <textarea name="description" id="description">{{old('description')}}</textarea>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="action">
                <div class="edit">
                    @if (Auth::user()->permission_id == 1)
                    <a href="{{route('product.index')}}">戻る</a>
                    @else
                    <a href="{{route('producer.showProduct')}}">戻る</a>
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
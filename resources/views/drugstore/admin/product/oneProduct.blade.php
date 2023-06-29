@extends('drugstore.app')

@section('title', '商品詳細')
{{-- @php dd( Auth::user()); @endphp --}}
@section('CSS')
<link rel="stylesheet" href={{asset('./css/product.css')}}>
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="product-wrap">
        <h1 class="product-title">商品詳細</h1>
        <div class="product-main">
            <div class="back">
                @if (!empty($typeId))
                    @if (Auth::user()->permission_id == 1)
                    <a href="{{route('admin.productType',['id'=>$typeId])}}"><i class="fa-solid fa-arrow-left"></i></a>
                    @endif
                @else
                    @if (Auth::user()->permission_id == 1)
                        @if (!empty($page))
                        <a href="{{route('product.index')}}"><i class="fa-solid fa-arrow-left"></i></a>
                        @else
                        <a href="{{route('admin.index')}}"><i class="fa-solid fa-arrow-left"></i></a>
                        @endif
                    @else
                    <a href="{{route('producer.showProduct')}}"><i class="fa-solid fa-arrow-left"></i></a>
                    @endif
                @endif

            </div>
            <div class="product-image">
                <img src="{{ asset('img/product_img/' . $product->image) }}" alt="img">
            </div>
            <div class="product-info">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-item__action">
                    <span class="product-item__like product-item__like--liked" data-product-id="{{$product->id}}">
                        @php
                        $likes = session()->get('likes');
                        $productLiked = isset($likes[$product->id]) && $likes[$product->id] === true;
                        $like_db = $like ? true : false
                        @endphp

                        @if ($productLiked  || $like_db)
                        {{-- check theo session ban dau --}}
                        <i id="like-icon-empty" class="product-item__like-icon-empty fa-regular fa-heart" style="display:none;"></i>
                        <i id="like-icon-fill" class="product-item__like-icon-fill fa-solid fa-heart"></i>
                        @else

                        <i id="like-icon-empty" class="product-item__like-icon-empty fa-regular fa-heart"></i>
                        <i id="like-icon-fill" class="product-item__like-icon-fill fa-solid fa-heart" style="display:none;"></i>
                        @endif
                    </span>
                    <div class="product-item__rating">
                        <span class="item__rating-number">{{--{{$starnumber}} --}}{{$product->star}}</span>
                        @for ($i = 0; $i < $product->star; $i++)
                            <i class="product-item__star--gold fa-solid fa-star"></i>
                            @endfor
                            @php
                            $remain = 5 - $product->star;
                            @endphp
                            @for ($i = 0; $i < $remain; $i++) <i class="fa-solid fa-star"></i>
                                @endfor
                    </div>
                    <span class="product-item__sold">({{$product->sold}})</span>
                </div>
                <div class="product-price">
                    @if ($product->sale_off > 0)
                    <div class="product-price__old">
                        <span class="price__old-tittle">過去価格: </span>
                        <span class="price__old-number">{{ $product->price }}円</span>
                    </div>
                    <div class="product-price__sale">
                        <span class="price__sale-tittle">タイムセール: </span>
                        <span class="price__sale-number">{{ round($product->price * (100 - $product->sale_off) / 100)  }}円</span>
                    </div>
                    @else
                    <div class="product-price__sale">
                        <span class="price__sale-tittle">価格: </span>
                        <span class="price__sale-number">{{ $product->price }}円</span>
                    </div>
                    @endif
                </div>
                <div class="product-description">
                    {!! nl2br(e($product->description)) !!}
                </div>
       
            </div>
        </div>
        @if (Auth::user()->permission_id == 1)
        @if (!empty($page))
        <div class="action">
            <div class="delete">
                <form action="{{route('product.destroy',['product' => $product->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('No {{$product->id}} を削除しますか？')">削除</button>
                    <input type="hidden" name="delete" value="{{$product->id}}">
                </form>
            </div>
            <div class="edit"><a href="{{route('product.edit', ['product' => $product->id])}}">編集</a></div>
        </div>
        @endif
        @else
        <div class="action">
            <div class="delete">
                <form action="{{route('producer.productDestroy',['id' => $product->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('No {{$product->id}} を削除しますか？')">削除</button>
                    <input type="hidden" name="delete" value="{{$product->id}}">
                </form>
            </div>
            <div class="edit"><a href="{{route('producer.productEdit', ['id' => $product->id])}}">編集</a></div>
        </div>
        @endif
    </div>
</div>
@endsection
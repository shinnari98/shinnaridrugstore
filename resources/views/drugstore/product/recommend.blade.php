@php
if (session()->has('user') && $likes != null) {
// dd('true');
if (count($likes) > 0) {
foreach ($likes as $like) {
$like_db[] = $like->product_id;
}
}else {
$like_db = [];
}
}
@endphp
<div class="recommend">
    <h3 class="recommend-title">おすすめ</h3>
    <div class="recommend-list">

        @foreach ($recommends as $recommend)
        @if (Auth::user() && Auth::user()->permission_id == 1)
        <a class=" product-item" href="{{ route('product.show',['product'=>$recommend->id]) }}">
            @else
            <a class=" product-item" href="{{ route('product.showUser',['id'=>$recommend->id]) }}">
                @endif

                <div class="product-item__img"
                    style="background-image: url('{{asset('img/product_img/'.$recommend->image)}}');">
                </div>
                <h4 class="product-item__name">{{$recommend->name}}</h4>
                @if ($recommend->sale_off > 0)
                <div class="product-item__price">
                    <div class="item__price-old">{{number_format($recommend->price)}}</div>
                    <div class="item__price-current">
                        <span style="font-size: 1rem;color: var(--text-color);">(税抜)</span>
                        {{number_format(round($recommend->price*(100-$recommend->sale_off)/100))}}円
                    </div>
                </div>
                @else
                <div class="product-item__price" style="justify-content: center">
                    <p style="color: var(--text-color);margin-right:5px;">(税抜)</p>
                    <div class="item__price-current"> {{number_format($recommend->price)}}円</div>
                </div>
                @endif

                <div class="product-item__action">
                    <span class="product-item__like{{--  product-item__like--liked --}}">
                        @php
                        if (Auth::user() ) {
                        $liked = in_array($recommend->id, $like_db);
                        }
                        $likes = session()->get('likes');
                        $productLiked = isset($likes[$recommend->id]) && $likes[$recommend->id] === true;
                        @endphp

                        @if (Auth::user())
                        @if ($productLiked || $liked)
                        <i class="product-item__like-icon-empty fa-regular fa-heart" style="display:none;"></i>
                        <i class="product-item__like-icon-fill fa-solid fa-heart"></i>
                        @else
                        <i class="product-item__like-icon-empty fa-regular fa-heart"></i>
                        <i class="product-item__like-icon-fill fa-solid fa-heart" style="display:none;"></i>
                        @endif
                        @else {{-- not user --}}
                        @if ($productLiked)
                        <i class="product-item__like-icon-empty fa-regular fa-heart" style="display:none;"></i>
                        <i class="product-item__like-icon-fill fa-solid fa-heart"></i>
                        @else

                        <i class="product-item__like-icon-empty fa-regular fa-heart"></i>
                        <i class="product-item__like-icon-fill fa-solid fa-heart" style="display:none;"></i>
                        @endif
                        @endif
                    </span>
                    <div class="product-item__rating">
                        <span class="item__rating-number">{{$recommend->star}}</span>
                        @for ($i = 0; $i < $recommend->star; $i++)
                            <i class="product-item__star--gold fa-solid fa-star"></i>
                            @endfor
                            @php
                            $remain = 5 - $recommend->star;
                            @endphp
                            @for ($i = 0; $i < $remain; $i++) <i class="fa-solid fa-star"></i>
                                @endfor
                    </div>
                    <span class="product-item__sold">{{$recommend->sold}}</span>
                </div>
                <div class="product-item__producer">
                    @if (!empty($recommend->producer->nickname))
                    <span>{{$recommend->producer->nickname}}</span>
                    @endif
                </div>
                @if (in_array($recommend->id, $famous));
                <div class="product-item__favourite">
                    <i class="fa-solid fa-check"></i>
                    <span>人気</span>
                </div>
                @endif

                @if ($recommend->sale_off > 0)
                <div class="product-item__sale">
                    <span class="product-item__sale-off-persent">{{$recommend->sale_off}}%</span>
                    <span class="product-item__sale-off-label">OFF</span>
                </div>
                @endif
            </a>
            @endforeach
    </div>
</div>
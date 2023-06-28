<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function () {
    /*  ajax search */
    $('.nav-search__history').hide();
    $('.nav-search__input, nav-bigSearch__wrap').keyup(function (e) {
        e.preventDefault();
        var _text = $(this).val().trim();
        var _url = "{{ asset('img/product_img') }}";
        if (_text != '') {
            $.ajax({
                url: "{{route('ajax-search-products')}}?key=" + _text,
                type: 'GET',
                success: function (res) {
                    $('.modall').show()
                    $('.nav-search__history').show()
                    $('.nav-search__history').html(res)
                }
            })
        } else {
            $('.nav-search__history').html('');
            $('.nav-search__history').hide();
        }  
    })

    /* delete cart item */   
    $('#nav-cart__wrap').on("click", ".cart__list-delete i", function () {
        var id = $(this).data('id');
        var quantity = $(this).closest('.cart__list').find('.quantity-number').data('quantity');
        $.ajax({
            // url: './product/deleteCart/' + id,
            url: "{{ route('product.deleteCart')}}?id="+ id ,
            type: 'GET',
            data: {
                quantity: quantity,
            },
        }).done(function (res) {
            showCartList(res);
            alertify.success('カートからの商品を削除しました。');
        });
    });

    $('.down-product__star-btn').click(function() {
        var star = $(this).siblings('.down-product__star-input').val();
        var id = $(this).siblings('.down-product__id-input').val()
        // console.log(star, id)
        $.ajax({
            url: "{{route('product.star')}}?id=" + id,
            type: 'GET',
            data: {
                star: star,
            },
        }).done(function (res) {
            // here処理
            alertify.success('ご評価ありがとうございました。');
        });
    })

    /* ajax heart like */
    $('.product-item__like--liked').click(function (e) {  /*#like-icon-empty  */
        e.preventDefault();
        var productId = e.target.parentNode.dataset['productId'];
        var isLike = e.target.previousElementSibling == null; /*?  true : false */
        // console.log(productId);
        // console.log(isLike);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('product.like')}}?id="+productId,
            type: 'POST',
            data: {
                productId: productId,
                isLike: isLike,
            },
            success: function (response) {
                if (isLike == true) {
                    $('#like-icon-empty').hide();
                    $('#like-icon-fill').show();
                } else {
                    $('#like-icon-fill').hide()
                    $('#like-icon-empty').show()
                }
            }
        })
            .done(function () {

            })
    })
})
function addCart(event, id) {
    event.preventDefault();
    var quantity = $('.product-quantity__number input').val();
    $.ajax({
        url: "{{ route('product.cart') }}?id=" + id,
        // url: 'addCart/' + id,
        type: 'GET',
        data: {
            quantity: quantity,
        },
    }).done(function (res) {
        showCartList(res);
        alertify.success('カートに入れました。');
    });
}
</script>
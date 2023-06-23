$(function () {
    /* show cart */
    $('.nav-cart').hover(
        function () {
            $('.nav-cart__table').fadeIn()
        },
        function () {
            $('.nav-cart__table').fadeOut()
        });

    /* show user menu */
    $('.nav-login').hover(
        function () {
            $('.user-menu').fadeIn(200)
        },
        function () {
            $('.user-menu').fadeOut(200)
        });
    /*
    // show modal vs navbar and re-navbar
    $(".nav-login, .re-navbar__login").click(function () {
        $(".modal").fadeIn();
        $(".login-box").animate({ top: "0", opacity: "1" }, 700);
    });

    // ngăn nổi bọt ở modal
    $(".login-box").click(function (event) {
        event.stopPropagation();
    });

     // ẩn modal
    $(".overlay").click(function () {
        $(".modal").fadeOut();
        $(".login-box").animate({ top: "50vh", opacity: 0 }, 700);
    });

    /*  ajax search */
    $('.nav-search__history').hide();

    $('.nav-search__input, nav-bigSearch__wrap').keyup(function (e) {
        e.preventDefault();
        var _text = $(this).val().trim();
        var _url = "{{ asset('img/product_img') }}";
        if (_text != '') {
            $.ajax({/* http://localhost/api/ajax-search-products == {{route('ajax-search-products')}} */
                url: 'http://localhost/ajax-search-products?key=' + _text,
                type: 'GET',
                success: function (res) {
                    /* var _html = '';
                    _html += '<h3 class="nav-search__history-heading">SEARCH HISTORY</h3>';
                    _html += '<ul class="nav-search__history-list">';
                    for (let pro of res) {
                        var slug = convertToSlug(pro.name);
                        _html += '<li class="nav-search__history-item">';
                        _html += '<a href="http://localhost/product/'+ pro.id +'">';
                        _html += '<img alt="img" src="' + _url + '/' + pro.image + '">';
                        _html += '<span>' + pro.name + '</span>';
                        _html += '</a>';
                        _html += '</li>';
                    }
                    _html += '</ul>'; */
                    // $('.nav-search__history').html(_html)
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

    $('.modall').click(function () {
        $('.modall').hide();
        $('.nav-search__history').hide();
    })

    /* ajax heart like */
    $('.product-item__like--liked').click(function (e) {  /*#like-icon-empty  */
        e.preventDefault();
        var productId = e.target.parentNode.dataset['productId'];
        var isLike = e.target.previousElementSibling == null; /*?  true : false */
        // console.log(productId);
        console.log(isLike);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `http://localhost/product/${productId}/like`,
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

    /* show re-navbar menu  */
    $('.re-navbar').hover(
        function () {
            $('.re-navbar__menu').fadeIn(200)
        },
        function () {
            $('.re-navbar__menu').fadeOut(200)
        });

    /* show thanh search to */
    $('.nav-re-search__btn').click(function () {
        $('.nav-bar').css({ 'display': 'none' })
        $('.nav-bigSearch__wrap').css({ 'display': 'block' })
    })

    /* from search to back lai */
    $('.nav-bigSearch__back').click(function () {
        $('.nav-bar').css({ 'display': 'flex' })
        $('.nav-bigSearch__wrap').css({ 'display': 'none' })
    })

    $(window).resize(function () {
        if ($(window).width() > 504) {
            $('.nav-bar').css({ 'display': 'flex' })
            $('.nav-bigSearch__wrap').css({ 'display': 'none' })
        }
    })


    /* $(".slider img:nth-child(n+2)").hide();
    setInterval(function () {
        $(".slider img:first-child").fadeOut(2000);
        $(".slider img:nth-child(2)").fadeIn(2000);
        $(".slider img:first-child").appendTo(".slider");
    }, 4000); */

    $('.slider-next').click(function () {
        changeImg('next', 500);
    })

    $('.slider-previous').click(function () {
        changeImg('previous', 500);
    })

    setInterval(function () {
        $('.slider-next').click();
    }, 4000);

    $('.slide-change-img button').click(function () {
        let eqNumber = $(this).attr('idx');
        $('.slider .slider-img').fadeOut();
        $('.slider .slider-img').eq(eqNumber).fadeIn();
        $(".slide-change-img button").removeClass("active");
        $(".slide-change-img button").eq(eqNumber).addClass("active");
    })

    /* use for paging */
    /* var windowWidth = window.innerWidth;
    console.log(windowWidth);
    var itemsPerPage;
    if (windowWidth < 590) {
        itemsPerPage = 4; 
    } else if (windowWidth < 780) {
        itemsPerPage = 6; 
    } else if (windowWidth < 992) {
        itemsPerPage = 8; 
    } else {
        itemsPerPage = 10; 
    } */

    /* change quantity */
    $('.product-quantity__plus').click(function () {
        var quantity = parseInt($('.product-quantity__number input').val());
        var newVal = quantity + 1;
        $('.product-quantity__number input').val(newVal);
    });

    $('.product-quantity__minus').click(function () {
        var quantity = parseInt($('.product-quantity__number input').val());
        if (quantity > 1) {
            var newVal = quantity - 1;
            $('.product-quantity__number input').val(newVal);
        }
    });

    /* delete cart item */
    $('#nav-cart__wrap').on("click", ".cart__list-delete i", function () {
        var id = $(this).data('id');
        var quantity = $(this).closest('.cart__list').find('.quantity-number').data('quantity');
        $.ajax({
            url: 'http://localhost/product/deleteCart/' + id,
            type: 'GET',
            data: {
                quantity: quantity,
            },
        }).done(function (res) {
            showCartList(res);
            alertify.success('カートからの商品を削除しました。');
        });
    });

    /* show card-info */
    $('input[name="pay"]').change(function () {
        if ($(this).val() == 'card') {
            $('#card-info').show();
        } else {
            $('#card-info').hide();
        }
    })
    $(document).ready(function () {
        if ($('input[name="pay"]:checked').val() == 'card') {
            $('#card-info').show();
        }
        // console.log($('#forDelivery').val());
        $('#deli_status option').each(function() {
            if ($(this).val() == $('#forDelivery').val()) {
                $(this).prop('selected', true);
            }
        });
            
    });

    /* show user info input in checkbox*/
    $('.form-checkbox').change(function () {
        if (this.checked) {
            $(this).prev('.form-input').prop('disabled', this.checked).val('');
            // $(this).prev('.form-input').prop('', true).val('');
        } else {
            $(this).prev('.form-input').prop('disabled', false);
        }
    })

    /* show user changePassword box */
    $('#changePassword').click(function () {
        var changePassBox = $('#changePass__box');
        if (changePassBox.is(':visible')) {
            changePassBox.fadeOut();
            $('#changePass__box input').val('');
            // Xóa rule required cho các trường input khi ẩn bảng
            $('#oldPassword').removeAttr('required');
            $('#newPassword').removeAttr('required');
            $('#passConfirm').removeAttr('required');
        } else {
            changePassBox.fadeIn();
            // Thêm rule required cho các trường input khi hiển thị bảng
            $('#oldPassword').attr('required', true);
            $('#newPassword').attr('required', true);
            $('#passConfirm').attr('required', true);
        }
    })
    $(document).ready(function () {
        if ($('#changePass__box input').val() !== '') {
            $('#changePass__box').fadeIn();
        }
    });
    
    /* ajax star */
    $('.down-product__review p').click(function() {
        /* if ($(this).next('.down-product__star').is(':visible')) {
            $(this).next('.down-product__star').fadeOut();
        } else {
            $(this).next('.down-product__star').fadeIn();
        } */
        $(this).next('.down-product__star').toggle();
    })

    $('.down-product__star i').click(function() {
        var star = $(this).attr('star_value');
        $(this).closest('.down-product__star').find('.down-product__star-input').val(star);

        $(this).addClass('product-item__star--gold');
        $(this).prevAll('i').addClass('product-item__star--gold');
        $(this).nextAll('i').removeClass('product-item__star--gold');
    })

    $('.down-product__star-btn').click(function() {
        var star = $(this).siblings('.down-product__star-input').val();
        var id = $(this).siblings('.down-product__id-input').val()
        console.log(star, id)
        $.ajax({
            url: 'http://localhost/product/star/' + id,
            type: 'GET',
            data: {
                star: star,
            },
        }).done(function (res) {
            // here処理
            alertify.success('ご評価ありがとうございました。');
        });
    })

});

function changeImg(type, time = 2000) {
    let selectVisible = $('.slider .slider-img:visible');
    let imgVisible = parseInt(selectVisible.attr('idx'));
    let eqNumber = type === 'next' ? imgVisible + 1 : imgVisible - 1;

    if (eqNumber >= $('.slider .slider-img').length) {
        eqNumber = 0
    }
    if (eqNumber < 0) {
        eqNumber = $('.slider .slider-img').length - 1
    }

    let nextImg = $('.slider .slider-img').eq(eqNumber);

    let slideWidth = $('.slider .slider-img').width();
    // console.log(slideWidth)
    /*alert(slideWidth)
    let slideDirection = type === 'next' ? '-=' + slideWidth : '+=' + slideWidth;
    alert(slideDirection)
    // Ẩn hiện các slide
    selectVisible.animate({ left: slideDirection }, 500).fadeOut(500);
    nextImg.css('left', slideDirection).fadeIn(500).animate({ left: 0 }, 500); 
        .animate({left: slideWidth})*/

    nextImg.fadeIn(time);
    selectVisible.fadeOut(time);
    $(".slide-change-img button").removeClass("active");
    $(".slide-change-img button").eq(eqNumber).addClass("active");
}

function convertToSlug(Text) {
    return Text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
}

function addCart(event, id) {
    event.preventDefault();
    var quantity = $('.product-quantity__number input').val();
    $.ajax({
        url: 'http://localhost/product/addCart/' + id,
        type: 'GET',
        data: {
            quantity: quantity,
        },
    }).done(function (res) {
        showCartList(res);
        alertify.success('カートに入れました。');
    });
}

function showCartList(res) {
    $('#nav-cart__wrap').empty();
    $('#nav-cart__wrap').html(res);
    var allQuantity = $('#all-cart__number').val();
    if (allQuantity == null || allQuantity == NaN) {
        allQuantity = 0;
    }
    $('.nav-cart__notice').text(allQuantity);
}
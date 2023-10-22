@extends('front.layouts.master')
@section('content')
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <!-- STORE -->
                <div id="store" class="col-md-9">


                    <!-- store products -->
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 col-xs-6">
                                <div class="product">
                                    <div class="product-img">
                                        <img src="{{ asset($product->images[0]->image) }}" alt="">
                                        <div class="product-label">
                                            <span class="sale">-30%</span>
                                            <span class="new">NEW</span>
                                        </div>
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category">{{ $product->category->name }}</p>
                                        <h3 class="product-name"><a href="#">{{ $product->name }}</a></h3>
                                        <h4 class="product-price">${{ $product->price }}</h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="product-btns">
                                         @php
                                            $w_exist = false;
                                            $c_exist = false;
                                            if(Auth::user() && App\Models\Wishlist::where('product_id', $product->id)->where('user_id', Auth::user()->id)->exists()){
                                                $w_exist = true;
                                            }
                                            if(Auth::user() && App\Models\Cart::where('product_id', $product->id)->where('user_id', Auth::user()->id)->exists()){
                                                $c_exist = true;
                                            }
                                         @endphp
                                            <button data-id="{{ $product->id }}" class="add-to-wishlist"><i class="fa {{$w_exist ? 'fa-heart' : 'fa-heart-o' }}"></i><span
                                                    class="tooltipp">add to wishlist</span></button>
                                            <button class="add-to-compare"><i class="fa fa-exchange"></i><span
                                                    class="tooltipp">add to compare</span></button>
                                            <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick
                                                    view</span></button>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <button class="add-to-cart-btn" data-id = "{{ $product->id }}">{{$c_exist ? 'Remove from cart' : 'Add to cart' }}</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        {{-- <div class="clearfix visible-sm visible-xs"></div> --}}
                    </div>

                    {{-- <div class="store-filter clearfix">
                        <span class="store-qty">Showing 20-100 products</span>
                        <ul class="store-pagination">
                            <li class="active">1</li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div> --}}
                    <!-- /store bottom filter -->
                </div>
                <!-- /STORE -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>

    {{--  ----------------for add to cart---------------- --}}
    <script>
        $(document).on('click', '.add-to-cart-btn', function() {
            
            var url = "{{ route('user.add_to_cart') }}";
            var product_id = $(this).data('id');
            var quantity = 1;
            var cart_product = $('.cart_qty').text();
            var button = $(this);
            // console.log(product_id, quantity)
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')
                },
                type: "post",
                url: url,
                data: {
                    'product_id': product_id,
                    'quantity': quantity,
                }
            }).done(function(data) {
                console.log(data);
                if (data.status == 401) {
                    toastr.error('Please login first.', 'Login Require', {
                        timeOut: 3000
                    })
                } else if (data.status == 422) {
                    toastr.error('Try to refresh the page', 'Error', {
                        timeOut: 3000
                    })
                } else if (data.status == 409) {
                    button.html('<i class="fa fa-shopping-cart"></i> Add to cart');
                    toastr.error('Removed from cart.', 'Success', {
                        timeOut: 3000
                    })
                    if(parseInt(cart_product) > 0){
                        cart_product = parseInt(cart_product) - 1;
                        $('.cart_qty').text(cart_product);
                    }
                } else if (data.status == 200) {
                    button.html('<i class="fa fa-shopping-cart"></i> Remove from cart');

                    toastr.success('Product added to cart.', 'Success', {
                        timeOut: 3000
                    })
                    cart_product = parseInt(cart_product) + quantity;
                    $('.cart_qty').text(cart_product);
                }
            });
            // console.log(button.html())
        });
    </script>

    {{--  ----------------for add to wishlist---------------- --}}
    <script>
        $(document).on('click', '.add-to-wishlist', function() {
            var url = "{{ route('user.add_to_wishlist') }}";
            var product_id = $(this).data('id');
            var wishlist_count = $('.wishlist_qty').text();
            var icon =  $(this).find('.fa');
            console.log(wishlist_count);
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')
                },
                type: "post",
                url: url,
                data: {
                    'product_id': product_id,
                }
            }).done(function(data) {
                console.log(data);
                if (data.status == 401) {
                    toastr.error('Please login first.', 'Login Require', {
                        timeOut: 3000
                    })
                } else if (data.status == 422) {
                    toastr.error('Try to refresh the page', 'Error', {
                        timeOut: 3000
                    })
                } else if (data.status == 409) {
                    icon.removeClass('fa-heart').addClass('fa-heart-o');
                    toastr.error('Removed from wishlist.', 'Success', {
                        timeOut: 3000
                    })
                    if(parseInt(wishlist_count) > 0){
                        wishlist_count = parseInt(wishlist_count) - 1;
                        $('.wishlist_qty').text(wishlist_count);
                    }
                } else if (data.status == 200) {
                    toastr.success('Product added to wishlist.', 'Success', {
                        timeOut: 3000
                    })
                    icon.removeClass('fa-heart-o').addClass('fa-heart');
                    wishlist_count = parseInt(wishlist_count) + 1;
                    $('.wishlist_qty').text(wishlist_count);
                }
            });
        });
    </script>
@endsection

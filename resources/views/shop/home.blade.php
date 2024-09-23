@extends('shop_layout')
@section('content')

<?php use App\Http\Controllers\ProductController; ?>
<!--Slider Start-->
<div class="slider-area">
    <div class="swiper-container slider-active">
        <div class="swiper-wrapper">
            <!--Single Slider Start-->
            <div class="single-slider swiper-slide animation-style-01" style="background-image: url('public/kidolshop/images/slider/123.png');">
                <div class="container">
                    <div class="slider-content">
                        <h5 class="sub-title">Nhập: <span class="text-primary">SALE100K</span> <br> Giảm 100K cho mọi đơn hàng</h5>
                        <h2 class="main-title">Ngày đặc biệt!</h2>
                        <p>Nhập: <span class="text-primary">SALE10</span> để được giảm 10%, số lượng có hạn!</p>

                        <ul class="slider-btn">
                            <li><a href="{{URL::to('/store')}}" class="btn btn-round btn-primary">Bắt đầu mua sắm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--Single Slider End-->

            <!--Single Slider Start-->
            <div class="single-slider swiper-slide animation-style-01" style="background-image: url('public/kidolshop/images/slider/345.png');">
                <div class="container" style="text-align:right;">
                    <div class="slider-content">
                        <h5 class="sub-title sub-title-right">Nhập: <span class="text-info">SALE100K</span> <br> Giảm 100K cho mọi đơn hàng</h5>
                        <h2 class="main-title">Ngày đặc biệt!</h2>
                        <p>Nhập: <span class="text-info">SALE10</span> để được giảm 10%, số lượng có hạn!</p>

                        <ul class="slider-btn">
                            <li><a href="{{URL::to('/store')}}" class="btn btn-round btn-primary">Bắt đầu mua sắm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--Single Slider End-->
        </div>
        <!--Swiper Wrapper End-->

        <!-- Add Arrows -->
        <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
        <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>

        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>

    </div>
    <!--Swiper Container End-->
</div>
<!--Slider End-->



<!--Shipping Start-->
<div class="shipping-area section-padding-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="public/kidolshop/images/shipping-icon/Free-Delivery.png" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Miễn Phí Vận Chuyển</h5>
                        <p>Giao hàng miễn phí cho tất cả các đơn đặt hàng trên 1.000.000đ</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="public/kidolshop/images/shipping-icon/Online-Order.png" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Đặt Hàng Online</h5>
                        <p>Đừng lo lắng, bạn có thể đặt hàng Trực tuyến trên Trang web của chúng tôi</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="public/kidolshop/images/shipping-icon/Freshness.png" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Hiện Đại</h5>
                        <p>Cập nhật những sản phẩm mới nhất</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="public/kidolshop/images/shipping-icon/Made-By-Artists.png" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Hỗ Trợ 24/7</h5>
                        <p>Đội ngũ hỗ trợ trưc tuyến chuyên nghiệp</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Shipping End-->

<!--New Product Start-->
<div class="features-product-area section-padding-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9 col-sm-11">
                <div class="section-title text-center">
                    <h2 class="title">Sản Phẩm</h2>
                </div>
            </div>
        </div>
        <div class="product-wrapper">
           

            <div class="tab-content product-items-tab">
                <div class="tab-pane fade show active" id="tab3" role="tabpanel">
                    <div class="swiper-container product-active">
                        <div class="swiper-wrapper">
                            @foreach($list_bestsellers_pd as $key => $bestsellers_pd)
                            <div class="swiper-slide">
                                <div class="single-product">
                                    <div class="product-image">
                                        <?php $image = json_decode($bestsellers_pd->ImageName)[0];?>
                                        <a href="{{URL::to('/shop-single/'.$bestsellers_pd->ProductSlug)}}">
                                            <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}" alt="">
                                        </a>

                                        <?php
                                            $SalePrice = optional($bestsellers_pd->productAttributes->first())->Price;  
                                            $get_time_sale = ProductController::get_sale_pd($bestsellers_pd->idProduct); 
                                        ?>

                                        @if($get_time_sale)
                                            <?php $SalePrice = optional($bestsellers_pd->productAttributes->first())->Price - (optional($bestsellers_pd->productAttributes->first())->Price/100) * $get_time_sale->Percent; ?>
                                            <div class="product-countdown">
                                                <div data-countdown="{{$get_time_sale->SaleEnd}}"></div>
                                            </div>
                                            @if($bestsellers_pd->QuantityTotal == '0') <span class="sticker-new soldout-title">Hết hàng</span>
                                            @else <span class="sticker-new label-sale">-{{$get_time_sale->Percent}}%</span>
                                            @endif
                                        @elseif($bestsellers_pd->QuantityTotal == '0') <span class="sticker-new soldout-title">Hết hàng</span>;
                                        @endif

                                        <div class="action-links">
                                            <ul>
                                                <!-- <li><a class="AddToCart-Single" data-id="{{$bestsellers_pd->idProduct}}" data-PriceNew="{{$SalePrice}}" data-token="{{csrf_token()}}" data-tooltip="tooltip" data-placement="left" title="Thêm vào giỏ hàng"><i class="icon-shopping-bag"></i></a></li> -->
                                                <li><a class="add-to-compare" data-idcat="{{$bestsellers_pd->idCategory}}" id="{{$bestsellers_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="So sánh"><i class="icon-sliders"></i></a></li>
                                                <li><a class="add-to-wishlist" data-id="{{$bestsellers_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Thêm vào danh sách yêu thích"><i class="icon-heart"></i></a></li>
                                                <li><a class="quick-view-pd" data-id="{{$bestsellers_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Xem nhanh"><i class="icon-eye"></i></a></li> 
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content text-center">
                                        <h4 class="product-name"><a href="{{URL::to('/shop-single/'.$bestsellers_pd->ProductSlug)}}">{{$bestsellers_pd->ProductName}}</a></h4>
                                        <div class="price-box">
                                            @if($SalePrice < optional($bestsellers_pd->productAttributes->first())->Price)
                                                <span class="old-price">{{number_format(optional($bestsellers_pd->productAttributes->first())->Price,0,',','.')}}đ</span>
                                                <span class="current-price">{{number_format(round($SalePrice,-3),0,',','.')}}đ</span>
                                            @else
                                                <span class="current-price">{{number_format(optional($bestsellers_pd->productAttributes->first())->Price,0,',','.')}}đ</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-action d-flex flex-wrap">
                                        <div class="action btn-app">
                                            <a href="{{URL::to('/shop-single/'.$bestsellers_pd->ProductSlug)}}" class="btn btn-primary btn-app add-to-cart">Xem sản phẩm</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Add Arrows -->
                        <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                        <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="features-product-area section-padding-5">
    <div class="container">
        @foreach($categories as $category)
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-9 col-sm-11">
                    <div class="section-title text-center">
                        <h2 class="title">{{ $category->CategoryName }}</h2>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="tab-content product-items-tab">
                    <div class="tab-pane fade show active" id="tab3" role="tabpanel">
                        <div class="swiper-container product-active">
                            <div class="swiper-wrapper">
                                @foreach($category->products as $product)
                                    @if($product->StatusPro == 1) <!-- Kiểm tra trạng thái sản phẩm -->
                                        <div class="swiper-slide">
                                            <div class="single-product">
                                                <div class="product-image">
                                                    <?php 
                                                        // Giải mã JSON từ trường ImageName để lấy ảnh
                                                        $image = $product->productImages->isNotEmpty() ? json_decode($product->productImages->first()->ImageName)[0] : 'default-image.jpg'; 
                                                    ?>
                                                    <a href="{{ URL::to('/shop-single/' . $product->ProductSlug) }}">
                                                        <img src="{{ asset('public/storage/kidoldash/images/product/' . $image) }}" alt="{{ $product->ProductName }}">
                                                    </a>

                                                    <?php
                                                        // Lấy giá sản phẩm đầu tiên
                                                        $SalePrice = optional($product->productAttributes->first())->Price;
                                                        $get_time_sale = ProductController::get_sale_pd($product->id);
                                                    ?>

                                                    @if($get_time_sale)
                                                        <?php 
                                                            // Tính giá sau khi giảm
                                                            $SalePrice = optional($product->productAttributes->first())->Price - (optional($product->productAttributes->first())->Price / 100) * $get_time_sale->Percent; 
                                                        ?>
                                                        <div class="product-countdown">
                                                            <div data-countdown="{{ $get_time_sale->SaleEnd }}"></div>
                                                        </div>
                                                        @if($product->QuantityTotal == '0') 
                                                            <span class="sticker-new soldout-title">Hết hàng</span>
                                                        @else 
                                                            <span class="sticker-new label-sale">-{{ $get_time_sale->Percent }}%</span>
                                                        @endif
                                                    @elseif($product->QuantityTotal == '0') 
                                                        <span class="sticker-new soldout-title">Hết hàng</span>
                                                    @endif

                                                    <div class="action-links">
                                                        <ul>
                                                            <li><a class="add-to-compare" data-idcat="{{ $product->idCategory }}" id="{{ $product->id }}" data-tooltip="tooltip" data-placement="left" title="So sánh"><i class="icon-sliders"></i></a></li>
                                                            <li><a class="add-to-wishlist" data-id="{{ $product->id }}" data-tooltip="tooltip" data-placement="left" title="Thêm vào danh sách yêu thích"><i class="icon-heart"></i></a></li>
                                                            <li><a class="quick-view-pd" data-id="{{ $product->id }}" data-tooltip="tooltip" data-placement="left" title="Xem nhanh"><i class="icon-eye"></i></a></li> 
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-content text-center">
                                                    <h4 class="product-name"><a href="{{ URL::to('/shop-single/' . $product->ProductSlug) }}">{{ $product->ProductName }}</a></h4>
                                                    <div class="price-box">
                                                        @if($SalePrice < optional($product->productAttributes->first())->Price)
                                                            <span class="old-price">{{ number_format(optional($product->productAttributes->first())->Price, 0, ',', '.') }}đ</span>
                                                            <span class="current-price">{{ number_format(round($SalePrice, -3), 0, ',', '.') }}đ</span>
                                                        @else
                                                            <span class="current-price">{{ number_format(optional($product->productAttributes->first())->Price, 0, ',', '.') }}đ</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="product-action d-flex flex-wrap">
                                                    <div class="action btn-app">
                                                        <a href="{{ URL::to('/shop-single/' . $product->ProductSlug) }}" class="btn btn-primary btn-app add-to-cart">Xem sản phẩm</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Add Arrows -->
                        <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                        <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>




<!--New Product End-->
<!--New Product Start-->
<div class="new-product-area section-padding-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9 col-sm-11">
                <div class="section-title text-center">
                    <h2 class="title">Sản Phẩm Mới</h2>
                </div>
            </div>
        </div>
        <div class="product-wrapper">
            <div class="swiper-container product-active">
                <div class="swiper-wrapper">
                    @foreach($list_new_pd as $key => $new_pd)
                    <div class="swiper-slide">
                        <div class="single-product">
                            <div class="product-image">
                                <?php $image = json_decode($new_pd->ImageName)[0];?>
                                <a href="{{URL::to('/shop-single/'.$new_pd->ProductSlug)}}">
                                    <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}" alt="">
                                </a>

                                <?php
                                    $SalePrice = optional($new_pd->productAttributes->first())->Price;  
                                    $get_time_sale = ProductController::get_sale_pd($new_pd->idProduct); 
                                ?>

                                @if($get_time_sale)
                                    <?php $SalePrice = optional($new_pd->productAttributes->first())->Price - (optional($new_pd->productAttributes->first())->Price/100) * $get_time_sale->Percent; ?>
                                    <div class="product-countdown">
                                        <div data-countdown="{{$get_time_sale->SaleEnd}}"></div>
                                    </div>
                                    @if($new_pd->QuantityTotal == '0') <span class="sticker-new soldout-title">Hết hàng</span>
                                    @else <span class="sticker-new label-sale">-{{$get_time_sale->Percent}}%</span>
                                    @endif
                                @elseif($new_pd->QuantityTotal == '0') <span class="sticker-new soldout-title">Hết hàng</span>;
                                @endif

                                <div class="action-links">
                                    <ul>
                                        <!-- <li><a class="AddToCart-Single" data-id="{{$new_pd->idProduct}}" data-PriceNew="{{$SalePrice}}" data-token="{{csrf_token()}}" data-tooltip="tooltip" data-placement="left" title="Thêm vào giỏ hàng"><i class="icon-shopping-bag"></i></a></li> -->
                                        <li><a class="add-to-compare" data-idcat="{{$new_pd->idCategory}}" id="{{$new_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="So sánh"><i class="icon-sliders"></i></a></li>
                                        <li><a class="add-to-wishlist" data-id="{{$new_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Thêm vào danh sách yêu thích"><i class="icon-heart"></i></a></li>
                                        <li><a class="quick-view-pd" data-id="{{$new_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Xem nhanh"><i class="icon-eye"></i></a></li> 
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="product-content text-center">
                                <!-- <ul class="rating">
                                    <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                    <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                    <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                    <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                    <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                </ul> -->
                                <h4 class="product-name"><a href="{{URL::to('/shop-single/'.$new_pd->ProductSlug)}}">{{$new_pd->ProductName}}</a></h4>
                                <div class="price-box">
                                    @if($SalePrice < optional($new_pd->productAttributes->first())->Price)
                                        <span class="old-price">{{number_format(optional($new_pd->productAttributes->first())->Price,0,',','.')}}đ</span>
                                        <span class="current-price">{{number_format(round($SalePrice,-3),0,',','.')}}đ</span>
                                    @else
                                        <span class="current-price">{{number_format(optional($new_pd->productAttributes->first())->Price,0,',','.')}}đ</span>
                                    @endif
                                </div>
                               
                            </div>
                            <div class="product-action d-flex flex-wrap">
                                <div class="action btn-app">
                                    <a href="{{URL::to('/shop-single/'.$new_pd->ProductSlug)}}" class="btn btn-primary btn-app add-to-cart">Xem sản phẩm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Add Arrows -->
                <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
            </div>
        </div>
    </div>
</div>
<!--New Product End-->
<!--Recommend Product Start-->
<div class="new-product-area section-padding-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9 col-sm-11">
                <div class="section-title text-center">
                    <h2 class="title">Gợi Ý Cho Bạn</h2>
                    <p>A perfect blend of creativity, energy, communication, happiness and love. Let us arrange a smile for you.</p>
                </div>
            </div>
        </div>
        <div class="product-wrapper">
            <div class="swiper-container product-active">
                <div class="swiper-wrapper">
                    <?php 
                        if(Illuminate\Support\Facades\Session::get('idCustomer') == '') $idCustomer = session()->getId();
                        else $idCustomer = Illuminate\Support\Facades\Session::get('idCustomer');
                    ?>
                    @if(App\Models\Viewer::where('idCustomer',$idCustomer)->count() != 0)
                        <?php $id_pds = json_decode($recommend_pds); ?>
                        @foreach($id_pds as $key => $id_pd)
                        <?php $product = App\Http\Controllers\CartController::get_product($id_pd); ?>
                        <div class="swiper-slide">
                            <div class="single-product">
                                <div class="product-image">
                                    <?php $image = json_decode($product->ImageName)[0];?>
                                    <a href="{{URL::to('/shop-single/'.$product->ProductSlug)}}">
                                        <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}" alt="">
                                    </a>

                                    <?php
                                        $SalePrice = $product->Price;  
                                        $get_time_sale = ProductController::get_sale_pd($product->idProduct); 
                                    ?>

                                    @if($get_time_sale)
                                        <?php $SalePrice = $product->Price - ($product->Price/100) * $get_time_sale->Percent; ?>
                                        <div class="product-countdown">
                                            <div data-countdown="{{$get_time_sale->SaleEnd}}"></div>
                                        </div>
                                        @if($product->QuantityTotal == '0') <span class="sticker-new soldout-title">Hết hàng</span>
                                        @else <span class="sticker-new label-sale">-{{$get_time_sale->Percent}}%</span>
                                        @endif
                                    @elseif($product->QuantityTotal == '0') <span class="sticker-new soldout-title">Hết hàng</span>;
                                    @endif

                                    <div class="action-links">
                                        <ul>
                                            <!-- <li><a class="AddToCart-Single" data-id="{{$product->idProduct}}" data-PriceNew="{{$SalePrice}}" data-token="{{csrf_token()}}" data-tooltip="tooltip" data-placement="left" title="Thêm vào giỏ hàng"><i class="icon-shopping-bag"></i></a></li> -->
                                            <li><a class="add-to-compare" data-idcat="{{$product->idCategory}}" id="{{$product->idProduct}}" data-tooltip="tooltip" data-placement="left" title="So sánh"><i class="icon-sliders"></i></a></li>
                                            <li><a class="add-to-wishlist" data-id="{{$product->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Thêm vào danh sách yêu thích"><i class="icon-heart"></i></a></li>
                                            <li><a class="quick-view-pd" data-id="{{$product->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Xem nhanh"><i class="icon-eye"></i></a></li> 
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content text-center">
                                    <!-- <ul class="rating">
                                        <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                        <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                        <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                        <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                        <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                    </ul> -->
                                    <h4 class="product-name"><a href="{{URL::to('/shop-single/'.$product->ProductSlug)}}">{{$product->ProductName}}</a></h4>
                                    <div class="price-box">
                                        @if($SalePrice < $product->Price)
                                            <span class="old-price">{{number_format($product->Price,0,',','.')}}đ</span>
                                            <span class="current-price">{{number_format(round($SalePrice,-3),0,',','.')}}đ</span>
                                        @else
                                            <span class="current-price">{{number_format($product->Price,0,',','.')}}đ</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-action d-flex flex-wrap">
                                    <div class="action btn-app">
                                        <a href="{{URL::to('/shop-single/'.$product->ProductSlug)}}" class="btn btn-primary btn-app add-to-cart">Xem sản phẩm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        @foreach($recommend_pds as $key => $product)
                        <div class="swiper-slide">
                            <div class="single-product">
                                <div class="product-image">
                                    <?php $image = json_decode($product->ImageName)[0];?>
                                    <a href="{{URL::to('/shop-single/'.$product->ProductSlug)}}">
                                        <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}" alt="">
                                    </a>

                                    <?php
                                        $SalePrice = $product->Price;  
                                        $get_time_sale = ProductController::get_sale_pd($product->idProduct); 
                                    ?>

                                    @if($get_time_sale)
                                        <?php $SalePrice = $product->Price - ($product->Price/100) * $get_time_sale->Percent; ?>
                                        <div class="product-countdown">
                                            <div data-countdown="{{$get_time_sale->SaleEnd}}"></div>
                                        </div>
                                        @if($product->QuantityTotal == '0') <span class="sticker-new soldout-title">Hết hàng</span>
                                        @else <span class="sticker-new label-sale">-{{$get_time_sale->Percent}}%</span>
                                        @endif
                                    @elseif($product->QuantityTotal == '0') <span class="sticker-new soldout-title">Hết hàng</span>;
                                    @endif

                                    <div class="action-links">
                                        <ul>
                                            <!-- <li><a class="AddToCart-Single" data-id="{{$product->idProduct}}" data-PriceNew="{{$SalePrice}}" data-token="{{csrf_token()}}" data-tooltip="tooltip" data-placement="left" title="Thêm vào giỏ hàng"><i class="icon-shopping-bag"></i></a></li> -->
                                            <li><a class="add-to-compare" data-idcat="{{$product->idCategory}}" id="{{$product->idProduct}}" data-tooltip="tooltip" data-placement="left" title="So sánh"><i class="icon-sliders"></i></a></li>
                                            <li><a class="add-to-wishlist" data-id="{{$product->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Thêm vào danh sách yêu thích"><i class="icon-heart"></i></a></li>
                                            <li><a class="quick-view-pd" data-id="{{$product->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Xem nhanh"><i class="icon-eye"></i></a></li> 
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content text-center">
                                    <!-- <ul class="rating">
                                        <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                        <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                        <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                        <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                        <li class="rating-on"><i class="fa fa-star-o"></i></li>
                                    </ul> -->
                                    <h4 class="product-name"><a href="{{URL::to('/shop-single/'.$product->ProductSlug)}}">{{$product->ProductName}}</a></h4>
                                    <div class="price-box">
                                        @if($SalePrice < $product->Price)
                                            <span class="old-price">{{number_format($product->Price,0,',','.')}}đ</span>
                                            <span class="current-price">{{number_format(round($SalePrice,-3),0,',','.')}}đ</span>
                                        @else
                                            <span class="current-price">{{number_format($product->Price,0,',','.')}}đ</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-action d-flex flex-wrap">
                                    <div class="action btn-app">
                                        <a href="{{URL::to('/shop-single/'.$product->ProductSlug)}}" class="btn btn-primary btn-app add-to-cart">Xem sản phẩm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

                <!-- Add Arrows -->
                <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
            </div>
        </div>
    </div>
</div>
<!--Recommend Product End-->




<!--About Start-->
<!--About End-->







<!--Testimonial Start-->
<!-- <div class="testimonial-area" style="background-image: url(public/kidolshop/images/testimonial-bg.jpg);">
    <div class="container">
        <div class="swiper-container testimonial-active">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="single-testimonial text-center">
                        <p>Felis eu pede mollis pretium. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus lingua. felis eu pede mollis pretium.</p>

                        <div class="testimonial-author">
                            <img src="public/kidolshop/images/testimonial-img-1.png" alt="">
                            <span class="author-name">Torvi / COO</span>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="single-testimonial text-center">
                        <p>Felis eu pede mollis pretium. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus lingua. felis eu pede mollis pretium.</p>

                        <div class="testimonial-author">
                            <img src="public/kidolshop/images/testimonial-img-2.png" alt="">
                            <span class="author-name">Shara / Founder</span>
                        </div>
                    </div>
                </div>
            </div>

            <  -- Add Arrows -->
            <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
            <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
        </div>
    </div>
</div> -->
<!--Testimonial End-->



<!--Experts Start-->
<!-- <div class="experts-area section-padding-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9 col-sm-11">
                <div class="section-title text-center">
                    <h2 class="title">Flower Experts</h2>
                    <p>A perfect blend of creativity, energy, communication, happiness and love. Let us arrange a smile for you.</p>
                </div>
            </div>
        </div>
        <div class="expert-wrapper">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-expert text-center">
                        <div class="expert-image">
                            <img src="public/kidolshop/images/experts/team-1.jpg" alt="">
                        </div>
                        <div class="expert-content">
                            <h4 class="name">Marcos Alonso</h4>
                            <p>Biologist</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-expert text-center">
                        <div class="expert-image">
                            <img src="public/kidolshop/images/experts/team-2.jpg" alt="">
                        </div>
                        <div class="expert-content">
                            <h4 class="name">Shara friken</h4>
                            <p>Photographer</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-expert text-center">
                        <div class="expert-image">
                            <img src="public/kidolshop/images/experts/team-3.jpg" alt="">
                        </div>
                        <div class="expert-content">
                            <h4 class="name">Torvi greac</h4>
                            <p>Founder</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-expert text-center">
                        <div class="expert-image">
                            <img src="public/kidolshop/images/experts/team-4.jpg" alt="">
                        </div>
                        <div class="expert-content">
                            <h4 class="name">Alonso Gomej</h4>
                            <p>Florist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!--Experts End-->



<!--Blog Start-->
<div class="blog-area blog-bg section-padding-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9 col-sm-11">
                <div class="section-title text-center">
                    <h2 class="title">Bài Viết Của Chúng Tôi</h2>
                </div>
            </div>
        </div>
        <div class="blog-wrapper mt-30">
            <div class="swiper-container blog-active">
                <div class="swiper-wrapper">
                    @foreach($list_blog as $key => $blog)
                    <div class="swiper-slide">
                        <div class="single-blog">
                            <div class="blog-image">
                                <a href="{{URL::to('/blog/'.$blog->BlogSlug)}}"><img src="{{asset('public/storage/kidoldash/images/blog/'.$blog->BlogImage)}}" alt=""></a>
                            </div>
                            <div class="blog-content">
                                <h4 class="title"><a href="{{URL::to('/blog/'.$blog->BlogSlug)}}">{{$blog->BlogTitle}}</a></h4>
                                <div class="articles-date">
                                    <p><span>{{$blog->created_at}}</span></p>
                                </div>
                                <div class="four-line mb-4">{!!$blog->BlogDesc!!}</div>

                                <div class="blog-footer">
                                    <a class="more" href="{{URL::to('/blog/'.$blog->BlogSlug)}}">Tìm hiểu thêm</a>
                                    <!-- <p class="comment-count"><i class="icon-message-circle"></i> 0</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Add Arrows -->
                <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
            </div>
        </div>
    </div>
</div>
<!--Blog End-->

<!--Newsletter Start-->
<!-- <div class="newsletter-area section-padding-5">
    <div class="container">
        <div class="newsletter-form">
            <div class="section-title text-center">
                <h2 class="title">Join The Colorful Bunch!</h2>
            </div>
            <div class="form-wrapper">
                <input type="text" placeholder="Your email address">
                <button>Subscribe</button>
                <i class="icon-mail"></i>
            </div>
        </div>
    </div>
</div> -->
<!--Newsletter End-->

@endsection
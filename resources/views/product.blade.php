@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ route('category-view', ['id' => $product->categories[0]->id]) }}">{{ $product->categories[0]->name }} </a>
                        <span>{{ $product->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__left product__thumb nice-scroll">
                            @foreach($product->images as $index => $image)
                                <a class="pt {{ $index==0?'active':'' }}" href="#product-{{ $index }}">
                                    <img src="{{ $image->link }}" alt="">
                                </a>
                            @endforeach
                        </div>
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                @foreach($product->images as $index => $image)
                                    <img data-hash="product-{{ $index }}" class="product__big__img"
                                         src="{{ $image->link }}" alt="">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h3>{{ $product->name }}</h3>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span>( 138 reviews )</span>
                        </div>
                        <div class="product__details__price">{{ $product->currency }} {{ $product->price }}
                            <span>{{ $product->currency }} {{ $product->list_price }}</span></div>
                        <p>{{ $product->description }}</p>
                        <div class="product__details__button">
                            <div class="quantity">
                                <span>Quantity:</span>
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                            </div>
                            <a href="#" class="cart-btn"><span class="icon_bag_alt"></span> Add to cart</a>
                            <ul>
                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="#"><span class="icon_adjust-horiz"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>Quantity:</span>
                                    <div class="stock__checkbox">
                                        <span class="checkmark">{{ $product->quantity }}</span>
                                    </div>
                                </li>
                                @if(is_array($product->variants))
                                    <li>
                                        <span>{{ $product->variants[0]->name1 }}</span>
                                        <div class="size__btn">
                                            @foreach($product->variants as $variant)
                                                <label for="xs-{{ $variant->value1 }}" class="active">
                                                    <input type="radio" id="xs-{{ $variant->value1 }}">
                                                    {{ $variant->value1 }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </li>
                                    @if($product->variants[0]->name2)
                                        <li>
                                            <span>{{ $product->variants[0]->name2 }}:</span>
                                            @foreach($product->variants as $variant)
                                                <div>
                                                    <span>{{ $variant->value2 }} </span>
                                                </div>
                                            @endforeach
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Specification</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h6>Description</h6>
                                {!! $product->detail !!}
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <h6>Specification</h6>
                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                    quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                    Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                    voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                    consequat massa quis enim.</p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                    quis, sem.</p>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <h6>Reviews ( 2 )</h6>
                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                    quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                    Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                    voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                    consequat massa quis enim.</p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                    quis, sem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="related__title">
                        <h5>RELATED PRODUCTS</h5>
                    </div>
                </div>
                @foreach($products as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ $item->images[0]->link }}">
                                <div class="label new">New</div>
                                <ul class="product__hover">
                                    <li><a href="{{ $item->images[0]->link }}"><span class="icon_heart_alt"></span></a>
                                    </li>
                                    <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{ route('product-view', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                </h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">{{ $item->price }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->
@stop

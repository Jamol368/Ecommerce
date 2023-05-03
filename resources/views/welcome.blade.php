@extends('layouts.app')

@section('content')
    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="categories__item categories__large__item set-bg"
                         data-setbg="{{ $data[0]->products[0]->images[0]->link }}">
                        <div class="categories__text">
                            <h1>{{ $data[0]->products[0]->name }}</h1>
                            <p>{{ $data[0]->products[0]->description }}</p>
                            <a href="{{ route('product-view', ['id' => $data[0]->products[0]->id]) }}">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        @for($i=1; $i<5; $i++)
                            <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                                <div class="categories__item set-bg"
                                     data-setbg="{{ $data[$i]->products[0]->images[0]->link }}">
                                    <div class="categories__text">
                                        <h4>{{ $data[$i]->products[0]->name }}</h4>
                                        <p>{{ $data[$i]->products[0]->description }}</p>
                                        <a href="{{ route('product-view', ['id' => $data[$i]->products[0]->id]) }}">Shop
                                            now</a>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->
@stop

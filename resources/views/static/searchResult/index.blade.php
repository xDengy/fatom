@extends('layouts/main')

@section('breadcrumb_items')
    <li class="breadcrumb-item"><a href="/">Главная</a></li>
    <li class="breadcrumb-item active">Результаты поиска</li>
@endsection

@php
    if($q) {
        $title = 'Поиск по запросу "' . $q . '"';
    }
    else {
        $title = 'Введите запрос заново';
    }
@endphp

@section('seo')
    <title>{{$title}}</title>
@endsection

@section('content')

    <div class="container searchBlock">
        <h1 class="title">
            {{ $title  }}
        </h1>
        <div class="row">
            <div class="col-lg-8 offset-sm-2">
                <div class="catalog-products">
                    <div class="table">
                        @forelse($products as $product)
                            <div class="ms2_product product mse2-row">
                                <div class="product-img">
                                    <a href="{{route('product',$product)}}">
                                        <img src="{{$product->image_path}}" onerror="this.onerror=null; this.src='/images/noimage_200x185_c5c.jpg'"
                                             alt="{{$product->image_alt}}"
                                             title="{{$product->image_title}}">
                                    </a>
                                </div>
                                <div class="product-info__block">
                                    <div class="product-name">
                                        <a href="{{route('product',$product)}}">
                                            @php echo str_replace(config('domain.replace'), $active->domain_city_text, $product->title) @endphp
                                        </a>
                                    </div>
                                </div>

                                <button class="btn btn-primary openorder"
                                        data-add-to-cart
                                        data-url="{{route('cart.add',$product)}}"
                                        type="button" name="ms2_action"
                                        data-id="{{$product->id}}" value="1">
                                    В корзину
                                </button>
                            </div>
                        @empty
                            <p>Подходящих результатов не найдено</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        {{$products->links('static.catalogFilter.pagination')}}
    </div>

@endsection

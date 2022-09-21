@extends('layouts/glav')

@php $baseImagePath = asset('images/static/services') @endphp

@section('seo')
    <title>{{$seo->title}}</title>
    <meta name="description" content="{{$seo->description}}">
    <meta name="keywords" content="{{$seo->keywords}}">
@endsection

@section('mainblock')
    <!-- BEGIN banner -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="banner-content">
                        <h1><span>Металлопрокат и полимеры</span>Продажа, обработка</h1>
                        <div class="info">
                            <span>Быстрая доставка</span>
                            <span>в любую точку РФ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END banner -->

    <div class="videobg d-none d-sm-block">
        <video autoplay="" loop="" muted="" poster="/images/banner-bg.jpg">
            <source src="/video/main-cut.mp4" type="video/mp4">
            <source src="/video/main.webm" type="video/webm">
        </video>
    </div>

    <div class="mouse"><a href="/#products" class="scroll"></a></div>
    </div>
    </div>
@endsection
<!-- BEGIN mainblock -->
@section('content')
    <!-- BEGIN products-types -->
    <div class="products-types" id="products">
        <div class="container">
            <div class="types">
                <div class="heading">Наш каталог</div>
                <ul>
                    @foreach($menu as $key => $category)
                        @if($loop->iteration < 6)
                            <li class="type">
                                <a href="{{route('catalog.category',$category)}}">
                                    <div class="type-border">
                                        <p class="type-name">{{ $category->title }}</p>
                                    </div>
                                    <div class="type__image-block">
                                        <p class="type-image"><img src="{{ $category->image_path }}" alt="{{ $category->image_alt }}" title="{{ $category->image_title }}"></p>
                                    </div>
                                    <div class="type-border">
                                        <p class="type-order">Заказать</p>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- END products-types -->

    <!-- BEGIN services -->
    <div class="services">
        <div class="container">
            <h2 class="title title-link">
                Услуги
                <div class="link">
                    <a href="{{route('services')}}">
                        Смотреть все услуги
                    </a>
                </div>
            </h2>
            <div class="services-content">
                <div class="rotate" style="width: 644px;">Услуги</div>
                <div class="row">
                    @foreach($services as $key => $service)
                        <div class="col-lg-6">
                            <div class="service">
                                <div class="service-image">
                                    @php
                                        $attach = $service->attachment()->first();
                                        if(!$attach->url()) {
                                            $image = '/storage/' . $attach->path . $attach->name . '.' . $attach->extension;
                                        } else {
                                            $image = $attach->url();
                                        }
                                         $title = str_replace(config('domain.replace'), $active->domain_city_text, $service->title);
                                        $preview_text = str_replace(config('domain.replace'), $active->domain_city_text, $service->preview_text);
                                    @endphp
                                    <a href="{{route('service',$service)}}"><img src="{{ $image }}" alt="{{ $title }}"></a>
                                </div>
                                <div class="service-text">
                                    <a href="{{route('service',$service)}}" class="name">{{ $title }}</a>
                                    <div class="description">
                                        {{ $preview_text }}
                                    </div>
                                    <button onclick="window.location.href = '{{route('service',$service)}}';" class="btn btn-primary">Подробнее</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- END services -->

    <!-- BEGIN about -->

    <div class="about aboutUs">
        <div class="container">
            <div class="about-content">
                <div class="rotate">О компании</div>
                <div class="wrapper">
                    <div class="info">
                        <h2 class="info-heading">
                            О компании
                        </h2>
                        <h3 class="info-title">
                            {!! $seo->subtitle !!}
                        </h3>
                        <div class="info-text">
                            {!! $seo->fulldesc !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@extends('layouts/main')

@section('breadcrumb_items')
    <li class="breadcrumb-item"><a href="/">Главная</a></li>
    <li class="breadcrumb-item active">Услуги</li>
@endsection
@section('seo')
    <title>{{$seo->title}}</title>
    <meta name="description" content="{{$seo->description}}">
    <meta name="keywords" content="{{$seo->keywords}}">
@endsection

<?php $baseImagePath = asset('images/static/services') ?>
@section('content')
    <!-- BEGIN services -->
    <div class="servicesOuter">
        <div class="container">
            <div class="title title-link">Услуги</div>
            <div class="services-content">
                <div class="rotate">Услуги</div>
                <div class="row">
                    @foreach($services as $service)
                        <div class="col-lg-6">
                            <div class="service">
                                <div class="service-image">
                                    @php
                                        $attach = $service->attachment()->first();
                                        if ($attach){
                                            if(!$attach->url()) {
                                                $image = '/storage/' . $attach->path . $attach->name . '.' . $attach->extension;
                                            } else {
                                                $image = $attach->url();
                                            }
                                        }
                                    @endphp
                                    <a href="{{route('service',$service)}}">
                                        <img
                                            src="{{ $image }}"
                                            alt="{{ $service->title }}"></a>
                                </div>
                                <div class="service-text">
                                    <a href="{{route('service',$service)}}" class="name">
                                        @php
                                            $title = str_replace(config('domain.replace'), $active->domain_city_text, $service->title);
                                            $preview_text = str_replace(config('domain.replace'), $active->domain_city_text, $service->preview_text);
                                        @endphp
                                        {{ $title }}
                                    </a>
                                    <div class="description">
                                        {{ $preview_text }}
                                    </div>
                                    <button onclick="window.location.href = '{{route('service',$service)}}';"
                                            class="btn btn-primary">Подробнее
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- END services -->
@endsection

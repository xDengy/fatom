@extends('layouts.main')

@php
    $service->title = str_replace(config('domain.replace'), $active->domain_city_text, $service->title);
    $service->SEO_text = str_replace(config('domain.replace'), $active->domain_city_text, $service->SEO_text);
    $service->description = str_replace(config('domain.replace'), $active->domain_city_text, $service->description);
@endphp

@section('breadcrumb_items')
    <li class="breadcrumb-item"><a href="/">Главная</a></li>
    <li class="breadcrumb-item"><a href="{{route('services')}}">Услуги</a></li>
    <li class="breadcrumb-item active">{{ $service->title }}</li>
@endsection

@section('seo')
    <title>{{$service->title}}</title>
    <meta name="description" content="{{$service->description}}">
@endsection

<?php $baseImagePath = asset('images/static/services') ?>
@section('content')
    <!-- BEGIN services -->
    <div class="row">
        <div class="col-sm-10 offset-sm-1">
            <h1 class="title">{{ $service->title }}</h1>
            <!-- BEGIN textblock -->
            <div class="textblock textOuter">
                <p>
                    @php
                        $attach = $service->attachment()->get();
                        if(count($attach) > 1) {
                            $attach = $attach[1];
                        } else {
                            $attach = $attach[0];
                        }
                        if(!$attach->url()) {
                            $image = '/storage/' . $attach->path . $attach->name . '.' . $attach->extension;
                        } else {
                            $image = $attach->url();
                        }
                    @endphp
                    <img alt="{{ $service->title }}" height="342" src="{{ $image }}" style="float:right" width="320">
                    {{ $service->description }}
                </p>

                @php echo html_entity_decode($service->SEO_text) @endphp

            </div>
            <!-- END textblock -->
        </div>
        <!-- END services -->
@endsection

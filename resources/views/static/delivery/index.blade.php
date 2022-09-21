@extends('layouts.main')
@section('seo')
    <title>{{$seo->title}}</title>
    <meta name="description" content="{{$seo->description}}">
    <meta name="keywords" content="{{$seo->keywords}}">
@endsection

@section('breadcrumb_items')
    <li class="breadcrumb-item"><a href="/">Главная</a></li>
    <li class="breadcrumb-item active">{{$seo->title}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-10 offset-sm-1">
            <h1 class="title">{{ $seo->h1 }}</h1>
            <!-- BEGIN textblock -->
            <div class="textblock textOuter">
                {{ $seo->subtitle }}

                {!! htmlspecialchars_decode($seo->fulldesc) !!}
                {!! $seo->doptxt1 !!}
            </div>
            <!-- END textblock -->
        </div>
    </div>
@endsection

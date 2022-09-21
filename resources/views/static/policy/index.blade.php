@extends('layouts/main')

@section('breadcrumb_items')
    <li class="breadcrumb-item"><a href="/">Главная</a></li>
    <li class="breadcrumb-item active">{{$seo->title}}</li>
@endsection

@section('seo')
    <title>{{$seo->title}}</title>
    <meta name="description" content="{{$seo->description}}">
    <meta name="keywords" content="{{$seo->keywords}}">
@endsection

<?php $baseImagePath = asset('images/static/services') ?>
@section('content')
    <div class="row">
        <div class="col-sm-10 offset-sm-1">
            <h1 class="title">{{$seo->title}}</h1>
            <div class="textblock textOuter">
                {!! $seo->fulldesc !!}
            </div>
        </div>
    </div>
@endsection




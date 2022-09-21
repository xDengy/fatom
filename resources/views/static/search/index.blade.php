@extends('layouts/main')

@section('seo')
    <title>{{$seo->title}}</title>
    <meta name="description" content="{{$seo->description}}">
    <meta name="keywords" content="{{$seo->keywords}}">
@endsection

@section('title')
    {{ $title }}
@endsection
@section('description')
    {{ $description }}!
@endsection
@section('keywords') @endsection

@section('main_page_css_class')
    page search
@endsection

@section('breadcrumb_items')
    <li class="breadcrumb-item"><a href="/">Главная</a></li>
    <li class="breadcrumb-item active">Поиск</li>
@endsection

@section('content')
<h1 class="title">Поиск</h1>

<form action="/search" method="POST">
    @csrf {{ csrf_field() }}
    <input type="text" name="q" style="background: #000; color: #fff">
    <input type="submit" value="Поиск">
</form>
@endsection

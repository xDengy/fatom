@extends('layouts/main')

@section('breadcrumb_items')
    {{\Diglactic\Breadcrumbs\Breadcrumbs::render('catalog.category',$category)}}
    {{--    @foreach($seoData['bread'] as $bread)--}}
    {{--        <li class="breadcrumb-item @if ($loop->last) active @endif">--}}
    {{--            @if(isset($bread['url']))--}}
    {{--                <a href="{{$bread['url']}}">{{ $bread['title'] }}</a>--}}
    {{--            @else--}}
    {{--                {{ $bread['title'] }}--}}
    {{--            @endif--}}
    {{--        </li>--}}
    {{--    @endforeach--}}
@endsection
@section('seo')
    <title>{{$seoData['title']}}</title>
    <meta name="description" content="{{$seoData['description']}}">
    <meta name="keywords" content="{{$seoData['keywords']}}">
@endsection

@section('content')
    <div class="products-types">
        <div class="types">
            <div class="title">{{ $seoData['title'] }}</div>
            <div class="rotate"> {{ $category->title }} </div>
            <div class="subtitle"></div>
            <ul>
                @foreach($categories as $category)
                    <li class="type">
                        <a href="{{route('catalog.category',$category)}}">
                            <div class="type-border">
                                <p class="type-name">{{ $category->title }}</p>
                            </div>
                            <div class="type__image-block">
                                <p class="type-image">
                                    <img src="{{ $category->image_path }}" alt="{{$category->title}}">
                                </p>
                            </div>
                            <div class="type-border">
                                <p class="type-order">Подробнее</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@extends('layouts/main')

@section('breadcrumb_items')
    {{\Diglactic\Breadcrumbs\Breadcrumbs::render('catalog',)}}
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
@endsection

@section('content')
    <div class="products-types">
        <div class="types">
            @foreach($categories as $category)
                <div class="types">
                    <div class="title">
                        <a href="{{route('catalog.category',$category)}}">{{$category->title}}</a>
                    </div>
                    <div class="rotate">{{$category->title}}</div>
                    @if(count($category->children))
                        <ul class="list">
                            @foreach($category->children as $childCat)
                                @if($loop->iteration < 9)
                                    <li class="type">
                                        <a href="{{route('catalog.category',$childCat)}}">
                                            <div class="type-border">
                                                <p class="type-name">{{$childCat->title}}</p>
                                            </div>
                                            <div class="type__image-block">
                                                <p class="type-image">
                                                    <img src="{{ $category->image_path }}" alt="{{$childCat->title}}"></p>
                                            </div>
                                            <div class="type-border">
                                                <p class="type-order">Подробнее</p>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection

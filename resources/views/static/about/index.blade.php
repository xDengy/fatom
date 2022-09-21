@extends('layouts.main')

@section('main_page_css_class')
    page about
@endsection

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
    <h1 class="title">{{$seo->h1}}</h1>

    <!-- BEGIN infoblock -->
    <div class="infoblock">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="infoblock-text">
                    <!-- BEGIN textblock -->
                    <div class="textblock">
                        {{--                        @php $image = json_decode($page->image_path, true)[0] @endphp--}}
                        <p><img alt="" height="407" src="{{ $seo->hero }}" style="float:right" width="585"/></p>

                        @php
                            echo htmlspecialchars_decode($seo->subtitle)
                        @endphp

                        @php
                            echo htmlspecialchars_decode($seo->fulldesc)
                        @endphp

                        @if($seo->phone)
                            <p>Наши контактные телефоны: <strong>{{ $seo->phone }}.</strong></p>
                        @endif

                        <p>Мы будем рады сотрудничать с вами!<br/>&nbsp;</p>

                    </div>
                    <!-- END textblock -->
                </div>
            </div>
            <!--
            <div class="col-md-5 col-lg-6 col-xl-7">
                <div class="infoblock-image">
                    <img src="tpl/img/about.jpg" alt="">
                </div>
            </div>
            -->
        </div>
    </div>
    <!-- END infoblock -->

    <!-- BEGIN pluses -->
    @if(!empty($works))
        <div class="pluses">
            <div class="title">С нами выгодно работать</div>
            <div class="pluses-content">
                <div class="row">
                    @foreach($works as $key => $work)
                        <div class="col-md-6 col-lg-4">
                            <div class="plus">
                                <div class="plus-heading">
                                    <span>{{ $key+1 }}</span>
                                    <p>{{ $work->title }}</p>
                                </div>
                                <div class="plus-body">
                                    {{ $work->description }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <!-- END pluses -->

    <!-- BEGIN video -->

    <!-- END video -->
@endsection

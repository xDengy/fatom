@extends('layouts/main')

@section('breadcrumb_items')
    <li class="breadcrumb-item"><a href="">Главная</a></li>
    @foreach($data['bread'] as $key => $bread)
        <li class="breadcrumb-item @if(count($data['bread']) - 1 == $key) active @endif">
            @if(count($data['bread']) - 1 == $key)
                {{ $bread[1] }}
            @else
                <a href="/{{ $bread[0] }}">{{ $bread[1] }}</a>
            @endif
        </li>
    @endforeach
@endsection

@section('main_page_css_class')
    page products
@endsection
<?$baseImagePath = asset('images/static/catalog2')?>
@section('content')
    <div class="products-types">
        @foreach($data as $key => $value)
            @if($key !== 'par' && $key !== 'title' && $key !== 'bread')
                <div class="types">
                <div class="title">
                    <a href="/{{$data['par']}}/{{$value->transliterated_name}}">
                        {{$value->name}}
                    </a>
                </div>
                <div class="rotate">{{$value->name}}</div>
                <ul class="list">
                    @foreach($value->items as $k => $v)
                        @if($k < 4)
                            <li class="type">
                                <a href="/{{$data['par']}}/{{$value->transliterated_name}}/{{$v->transliterated_name}}">
                                    <div class="type-border">
                                        <p class="type-name">{{$v->name}}</p>
                                    </div>
                                    <p class="type-image"><img src="{{$v->image_path}}" alt="{{$v->image_alt}}" title="{{$v->image_title}}"></p>
                                    <div class="type-border">
                                    <p class="type-order">Подробнее</p>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
    @endforeach
</div>
@endsection

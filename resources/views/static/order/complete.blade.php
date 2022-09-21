@extends('layouts/main')

@section('breadcrumb_items')
    <li class="breadcrumb-item"><a href="/">Главная</a></li>
    <li class="breadcrumb-item active">Корзина</li>
@endsection

@section('seo')
    <title>{{$seo->title}}</title>
    <meta name="description" content="{{$seo->description}}">
    <meta name="keywords" content="{{$seo->keywords}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-10 offset-sm-1">
            <!-- BEGIN textblock -->
            <div class="textblock textOuter">
                <br class="clear">
                <div id="msCart">
                    <div class="textblock textOuter text-center">
                        <p>Уважаемый покупатель!</p>
                        <p>Благодарим Вас за заказ в нашем интернет магазине.</p>
                        <p>На ваш e-mail отправлено письмо с информацией о заказе.</p>
                        <p>В ближайшее время с Вами свяжется менеджер, для уточнения деталей о заказе.</p>
                        <p>Ждем Вас снова!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.mail')

@section('title')
    Новый заказ
@endsection

@section('content')

    <h1>Ваш заказ принят</h1>

    <h2 class="mt-5 mb-2">Товары</h2>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Название</th>
            <th scope="col">Цена</th>
            <th scope="col">Количество</th>
            <th scope="col">Всего</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->products as $item)
            <tr>
                <th>{{$item->id}}</th>
                <td>{{str_replace(config('domain.replace'),$active->domain_city_text,$item->title)}}</td>
                <td>{{$item->pivot->price}}</td>
                <td>{{$item->pivot->count}}</td>
                <td>{{$item->pivot->count*$item->pivot->price}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p>Спасибо за ваш заказ! <a href="{{url('/')}}">{{config('app.name')}}</a></p>
    <p>&copy; {{config('app.name')}}</p>

@endsection


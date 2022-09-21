@extends('layouts.mail')

@section('title')
    Новый заказ
@endsection

@section('content')

    <h1>новый заказ</h1>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Email</th>
            <th scope="col">Получатель</th>
            <th scope="col">Телефон</th>
            <th scope="col">Сообщение</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>{{$order->id}}</th>
            <th>{{$order->email}}</th>
            <td>{{$order->name}}</td>
            <td>{{$order->tel}}</td>
            <td>{{$order->message}}</td>
        </tr>
        </tbody>
    </table>
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

    <a class="btn btn-primary" target="_blank" href="{{route('platform.orders.editItem',$order->id)}}">Перейти</a>

@endsection


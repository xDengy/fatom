@extends('layouts/main')



@section('breadcrumb_items')
    <li class="breadcrumb-item"><a href="/">Главная</a></li>
    <li class="breadcrumb-item active">Корзина</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-10 offset-sm-1">
            <h1 class="title">Корзина</h1>
            <!-- BEGIN textblock -->
            <div class="textblock textOuter">
                <br class="clear">
                <div id="msCart">
                    @if(count($cart['items']))
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr class="">
                                    <th class="title">Наименование</th>
                                    <th class="price">Цена</th>
                                    <th class="count">Количество</th>
                                    <th class="weight">Итого</th>
                                    <th class="remove"></th>
                                </tr>
                                </thead>

                                <tbody>

                                {{--                                <tr class="footer">--}}
                                {{--                                    <th class="total">Итого:</th>--}}
                                {{--                                    <th class="total_count">--}}
                                {{--                                        <span class="ms2_total_count">1</span>--}}
                                {{--                                        шт.--}}
                                {{--                                    </th>--}}
                                {{--                                    <th class="total_weight text-nowrap">--}}
                                {{--                                        <span class="ms2_total_weight">0</span>--}}
                                {{--                                        кг.--}}
                                {{--                                    </th>--}}
                                {{--                                    <th class="total_cost text-nowrap" colspan="2">--}}
                                {{--                                        <span class="ms2_total_cost">10 334</span>--}}
                                {{--                                        руб.--}}
                                {{--                                    </th>--}}
                                {{--                                </tr>--}}

                                @foreach($cart['items'] as $cartItem)
                                    <!--                                    --><?php //dd($cartItem) ?>
                                    <tr id="{{$cartItem->id}}">
                                        <td class="title2">
                                            <div class="d-flex">
                                                <a href="{{route('product',$cartItem->associatedModel)}}" class="title2">
                                                    <span>{{$cartItem->name}}</span>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="price">
                                            <span class="mr-2 text-nowrap">{{$cartItem->price}} руб.</span>
                                        </td>
                                        <td class="count">
                                            <div class="form-group">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="count" value="{{$cartItem->quantity}}" data-cart-count data-id="{{$cartItem->id}}" data-url="{{route('cart.update')}}" class="form-control">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">шт.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        {{--                                    <td class="weight">--}}
                                        {{--                                        <span class="text-nowrap">0 кг.</span>--}}
                                        {{--                                    </td>--}}
                                        <td class="total">
                                            <span class="mr-2 text-nowrap"><span class="amount">{{$cartItem->getPriceSum()}}</span> руб.</span>
                                        </td>
                                        <td class="remove">
                                            <button class="btn btn-sm btn-danger" type="button" name="ms2_action" data-cart-remove data-url="{{route('cart.remove',$cartItem->id)}}">×</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a class="btn btn-danger backCat" href="{{route('catalog')}}">Перейти в каталог</a>
                        <a class="btn btn-danger backCat" href="{{route('cart.clear')}}">Очистить корзину</a>

                        <form class="ms2_form" id="msOrder" method="post" action="{{route('order.create')}}">
                            @csrf
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <h4>Данные получателя:</h4>
                                    <div class="form-group row input-parent">
                                        <label class="col-md-4 col-form-label" for="email">
                                            Email <span class="required-star">*</span>
                                        </label>
                                        <div class="col-md-8">
                                            <input type="text" id="email" placeholder="Email" name="email" value="{{old('email')}}" class="form-control @error('email') error @enderror">

                                        </div>
                                    </div>
                                    <div class="form-group row input-parent required">
                                        <label class="col-md-4 col-form-label" for="receiver">
                                            Получатель <span class="required-star">*</span>
                                        </label>
                                        <div class="col-md-8">
                                            <input type="text" id="receiver" placeholder="Получатель" name="name" value="{{old('name')}}" class="form-control required @error('name') error @enderror">
                                        </div>
                                    </div>
                                    <div class="form-group row input-parent required">
                                        <label class="col-md-4 col-form-label" for="phone">
                                            Телефон <span class="required-star">*</span>
                                        </label>
                                        <div class="col-md-8">
                                            <input type="text" id="phone" placeholder="Телефон" name="tel" value="{{old('tel')}}" class="form-control required @error('tel') error @enderror">
                                        </div>
                                    </div>

                                    <div class="form-group row input-parent">
                                        <label class="col-md-4 col-form-label" for="comment">
                                            Комментарий
                                        </label>
                                        <div class="col-md-8">
                                            <textarea name="message" id="comment" placeholder="Комментарий" class="form-control">{{old('message')}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6" id="payments">
                                </div>
                            </div>

                            <button type="submit" name="ms2_action" class="btn btn-danger ms2_link">Сделать заказ!</button>
                            <hr class="mt-4 mb-4">
                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-end">
                                <!--<h4 class="mb-md-0">Итого, с доставкой:</h4>
                                <h3 class="mb-md-0 ml-md-2"><span id="ms2_order_cost">10 334</span> руб.</h3> -->
                            </div>

                            {{--                            <input type="radio" name="delivery" value="1" id="delivery_1" data-payments="[1]" checked="">--}}
                        </form>
                    @else
                        <div class="alert alert-warning">
                            Ваша корзина пуста
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

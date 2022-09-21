@extends('layouts/main')

@section('main_page_css_class')
    tovar-content page catalog
@endsection

@section('seo')
    <title>{{$seoData['title']}}</title>
    <meta name="description" content="{{$seoData['description']}}">
    <meta name="keywords" content="{{$seoData['keywords']}}">
@endsection



@section('content')
    @php $product->title = str_replace(config('domain.replace'), $active->domain_city_text, $product->title) @endphp
    <h1>{{ $product->title }}</h1>

    <div class="form-horizontal ms2_form">
        <input type="hidden" name="id" value="{{$product->id}}">
        <div class="tovar-header">
            <div class="tovar-img">
                <img src="{{ $product->image_path }}"
                     alt="{{ $product->image_alt }}"
                     title="{{ $product->image_title }}">
            </div>

            <div class="tovar-description">
                <div class="tovar-price-from">Цена:</div>
                <div class="tovar-desc-top">
                    <div class="tovar-price">
                        <span>
                            {{ $product->price_title }}
                            <small>
                            </small>
                        </span>
                    </div>
                    <div class="tovar-buy">
                        <div class="tovar-quality">
                            <div class="input-number__minus">-</div>
                            <input class="input-number__input" type="text" name="count" data-cart-count id="product_price"
                                   pattern="^[0-9]+$" value="1">
                            <div class="input-number__plus">+</div>

                        </div>
                        <button type="submit" class="btn-red small" data-id="{{ $product->id  }}" name="ms2_action" data-add-to-cart data-url="{{route('cart.update.product')}}">
                            В корзину
                        </button>
                    </div>
                    <div class="tovar-attention" style="font-weight: 300;line-height: 1.2;">
                        *Цены носят ознакомительный характер, не являются публичной офертой
                        Для получения подробной информации о характеристиках товаров, условиях поставки, их наличии и
                        стоимости,
                        пожалуйста, отправьте заявку в отдел продаж
                    </div>
                </div>
                <div class="characterist">
                    <div class="title">Характеристики
                        <div class="btn-oneClickOrder-Gl">
                            <div class="btn-oneClickOrder small">
                                <a data-target=".quick_buy" data-toggle="modal" href="#">
                                    Купить в одинклик
                                </a>
                            </div>
                        </div>
                    </div>

                    <ul>
                        @foreach(explode(';', $product->options) as $k => $v)
                            @if($k < 3)
                                <li>
                                    <span>{{ explode('=', $v)[0] }}</span>
                                    <span></span>
                                    <b>
                                        {{ explode('=', $v)[1] }}
                                    </b>
                                </li>
                            @endif
                        @endforeach
                        <div id="option">
                            <a href="#char"
                               class="option__help option__help--open">
                                <span></span>
                                <div class="options">Все характеристики</div>
                                <span></span>
                            </a>
                        </div>
                    </ul>
                </div>


                <div class="tovar-specification">
                    <a class="item" href="dostavka-avtotransportom.html" target="_blank">
                        <div class="icon">
                            <img src="{{ asset('images/static/delivery/icon-1.png') }}" alt="">
                        </div>

                        <div class="specification-desc">
                            <div class="title">Быстрая доставка</div>
                        </div>

                        <div class="more">Подробнее</div>
                    </a>
                    <a class="item" href="varianty-oplaty.html" target="_blank">
                        <div class="icon">
                            <img src="{{ asset('images/static/delivery/icon-2.png') }}" alt="">
                        </div>

                        <div class="specification-desc">
                            <div class="title">Удобная оплата</div>
                        </div>

                        <div class="more">Подробнее</div>
                    </a>
                    <a class="item" href="kak-oformit-zakaz.html" target="_blank">
                        <div class="icon">
                            <img src="{{ asset('images/static/delivery/icon-3.png') }}" alt="">
                        </div>

                        <div class="specification-desc">
                            <div class="title">Оптом и в розницу</div>
                        </div>

                        <div class="more">Подробнее</div>
                    </a>


                    <a class="item" href="gidroabrazivnaya-rezka-metalla.html" target="_blank">
                        <div class="icon">
                            <img src="{{ asset('images/static/delivery/icon-4.png') }}" alt="">
                        </div>

                        <div class="specification-desc">
                            <div class="title">резка металла</div>
                        </div>

                        <div class="more">Подробнее</div>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="products-char">
        <div id="char"></div>
        <div class="tabs">
            <div class="tabs-top">
                <div class="tab-item tab-item--active" data-id="1">
                    <div class="tab-item__content">Характеристики</div>
                    <div class="tab-item__arrow"></div>
                </div>
                <div class="tab-item" data-id="2">
                    <div class="tab-item__content">Описание</div>
                    <div class="tab-item__arrow"></div>
                </div>
                <div class="tab-item" data-id="3">
                    <div class="tab-item__content">Доставка и оплата</div>
                    <div class="tab-item__arrow"></div>
                </div>
            </div>
            <div class="tabs-bottom">
                <div class="tab-content tab-content--active" data-id="1">
                    @foreach(explode(';', $product->options) as $k => $v)
                        @if($v)
                            <div class="tab-item__info">
                                <div class="left">
                                {{ explode('=', $v)[0] }}
                                </div>
                                <div class="right__item">
                                    {{ explode('=', $v)[1] }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="tab-content" data-id="2">
                    <div class="tab-item__info">
                        <div class="tab-desc">
                            @php $product->description = str_replace(config('domain.replace'), $active->domain_city_text, $product->description) @endphp
                            {{ $product->description?:$product->seo_description }}
                        </div>
                    </div>
                </div>
                <div class="tab-content payment" data-id="3">
                    <div class="tab-item__info">
                        <div class="left">Способы оплаты</div>
                        <div class="right">
                            <div class="right__item">Самовывоз</div>
                        </div>
                    </div>
                    <div class="tab-item__info">
                        <div class="left">Способы доставки</div>
                        <div class="right">
                            <div class="right__item">Оплата наличными</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(".tab-item").on("click", function () {
            let tabId = $(this).attr("data-id");
            let tabBottom = $(".tabs").find(".tabs-bottom");
            let selected = tabBottom.find("[data-id=" + tabId + "]");

            $(".tab-item--active").removeClass("tab-item--active");
            $(this).addClass("tab-item--active");

            tabBottom.find(".tab-content--active").removeClass("tab-content--active");

            selected.addClass("tab-content--active");
        });
    </script>
    @if(count($similarProducts) > 0)
        <div class="similar">
            <div class="title">Похожие предложения в категории</div>
            <div class="items-similar">
                @foreach($similarProducts as $k => $simProduct)
                    @php $simProduct->title = str_replace(config('domain.replace'), $active->domain_city_text, $simProduct->title) @endphp
                    <div class="item-similar">
                        <div class="img">
                            <a href="{{route('product',$simProduct)}}">
                                <img
                                    src="{{ $simProduct->image_path }}"
                                    alt="{{ $simProduct->image_alt }}"
                                    title="{{ $simProduct->image_title }}">
                            </a>
                        </div>
                        <div class="title-item">
                            <a href="{{route('product',$simProduct)}}">{{ $simProduct->title }}</a>
                        </div>
                        <a href="{{route('product',$simProduct)}}" class="btn-red">Подробнее ...</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection

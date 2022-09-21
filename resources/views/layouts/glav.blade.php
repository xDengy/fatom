<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('seo')
    <link href="/favicon.svg" rel="shortcut icon" type="image/svg+xml">

    <meta name="viewport" content="initial-scale=1">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fancybox/fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mCustomScrollbar/mCustomScrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/screen.css') }}" media="screen">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" media="screen">
    <link rel="stylesheet" href="{{ asset('css/minishop2/default.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/msearch2/default.css') }}" type="text/css"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <script type="text/javascript">miniShop2Config = {
            "cssUrl": "\/assets\/components\/minishop2\/css\/web\/",
            "jsUrl": "\/assets\/components\/minishop2\/js\/web\/",
            "actionUrl": "\/assets\/components\/minishop2\/action.php",
            "ctx": "web",
            "close_all_message": "\u0437\u0430\u043a\u0440\u044b\u0442\u044c \u0432\u0441\u0435",
            "price_format": [2, ".", " "],
            "price_format_no_zeros": true,
            "weight_format": [3, ".", " "],
            "weight_format_no_zeros": true
        };</script>

    <script type="text/javascript">
        if (typeof mse2Config == "undefined") {
            mse2Config = {"cssUrl": "\/assets\/components\/msearch2\/css\/web\/", "jsUrl": "\/assets\/components\/msearch2\/js\/web\/", "actionUrl": "\/assets\/components\/msearch2\/action.php"};
        }
        if (typeof mse2FormConfig == "undefined") {
            mse2FormConfig = {};
        }
        mse2FormConfig["c53205c27441c77af8f65ac10665e2c97a3b1818"] = {"autocomplete": "queries", "queryVar": "query", "minQuery": 3, "pageId": 404};
    </script>
    <link rel="stylesheet" href="{{ asset('css/ajaxform/default.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/cityfields/cityselect.css') }}" type="text/css"/>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

</head>

<body>

<!-- BEGIN out -->
<!-- Только для главной страницы к out нужно добавить index -->
<div class="out index" id="out">
    <!-- BEGIN mainblock -->
    <!-- Только для главной страницы нужен контейнер mainblock для header, navigation и banner -->
    <!-- BEGIN header -->
    <div class="mainblock">
        <header itemscope itemtype="http://schema.org/WPHeader" class="header">
            <div class="navigation">
                <div class="container">
                    <div class="menu" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
                        <ul class="">
                            <li class="first">
                                <a href="{{route('services')}}">Услуги</a>
                            </li>
                            <li>
                                <a href="{{route('about')}}">О компании</a>
                            </li>
                            <li>
                                <a href="{{route('delivery')}}">Доставка</a>
                            </li>
                            <li class="last">
                                <a href="{{route('contacts')}}">Контакты</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <meta itemprop="headline" content="ООО Фатом">
            <meta itemprop="description"
                  content="Металлопрокат оптом и в розницу в {{ $active->domain_city_text }}. Производство металлоизделий - Фатом">
            <meta itemprop="keywords"
                  content="металл, производство, доставка, {{ $active->domain_city }}, опт, розница, металлопрокат ">
            <div itemscope itemtype="http://schema.org/PostalAddress" class="container">
                <a href="#" class="mobmenu-toggle"><span></span></a>
                <div class="header-logo">
                    <a itemprop="url" href="/">
                        <img src="{{ asset('images/logo-index.png') }}"
                             alt="компания ООО «Фатом»">
                    </a>
                </div>
                <div class="header-contacts">
                    <div class="address">
                        <div class="icon" itemprop="streetAddress">
                            <div class="cfcity">
                                <a href="#cfCity" data-toggle="modal" data-target="#cfCity">{{ $active->domain_city }}</a>
                                <!--<div class="text-center cfcity_first">
                                <p>Ваш город<br />Краснодар?</p>
                                    <div class="text-center">
                                        <a href="#cfCity" class="btn btn-primary" data-dismiss="cfcity">Да</a>
                                        <a href="#cfCity" class="btn btn-default" data-toggle="modal" data-target="#cfCity">Нет</a>
                                    </div>
                            </div> -->
                            </div>
                            <!-- ул. Новороссийская, </br>д. 236/1 лит. А, оф. 103 -->
                        </div>

                    </div>
                    <div class="mail">
                        <p class="icon"><a href="mailto:{{ $settings->email }} ">{{ $settings->email }} </a></p>
                    </div>

                    <div class="phones">
                        <div class="phones-block">
                            <a href="tel:{{ $active->tel }}" class="mgo-number"
                               itemprop="telephone">{{ $active->tel }}</a>
                        </div>
                    </div>
                    <div class="callback">
                        <a href="#" data-toggle="modal" data-target=".modal-callback">Заказать звонок</a>
                    </div>

                    <div class="catalog">
                        Каталог
                        <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect y="1" width="5" height="2" rx="1" fill="#DE202C"/>
                            <rect y="6" width="3" height="2" rx="1" fill="#DE202C"/>
                            <rect y="11" width="5" height="2" rx="1" fill="#DE202C"/>
                            <rect x="16.4775" y="9.87946" width="6.50783" height="2" rx="1" transform="rotate(48 16.4775 9.87946)" fill="#DE202C"/>
                            <circle cx="12" cy="7" r="6" stroke="#DE202C" stroke-width="2"/>
                        </svg>
                    </div>
                    @php
                        $count = \Cart::session(session()->getId())->getTotalQuantity()
                    @endphp
                    <div>
                        <div id="msMiniCart" class="">
                            <div class="empty">
                                <a href="{{route('cart')}}">
                                    <!--  <h5>Корзина</h5>Вы еще ничего не выбрали -->
                                </a>
                            </div>
                            <div class="not_empty">
                                <a href="{{route('cart')}}"><strong class="ms2_total_count">{{$count}}</strong></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END header -->

        <div class="mobile-catalog">
            <ul class="nav navbar-nav">
                <div class="submenu1">
                    Каталог
                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="17.0312" width="24" height="1.5" transform="rotate(-45 0 17.0312)" fill="#DE202C"/>
                        <rect x="17" y="18.0312" width="24" height="1.5" transform="rotate(-135 17 18.0312)" fill="#DE202C"/>
                    </svg>
                </div>
                @foreach($menu as $category)
                    <li class="submenu1 dropdown">
                        <div class="dropdown-row">
                            <a class="dropdown-toggle" href="{{route('catalog.category',$category)}}">
                                {{ $category->title }}
                                <span class="caret"></span>
                            </a>
                            <div class="arrow-zone">
                                <span class="dropdown-arrow"></span>
                            </div>
                        </div>
                        @if(count($category->children))
                            <ul class="dropdown-menu mobile-catalog__sub">
                                <div class="submenu2">
                                    <svg width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0.305588 7.79289C-0.0849361 8.18342 -0.0849361 8.81658 0.305588 9.20711L6.66955 15.5711C7.06007 15.9616 7.69324 15.9616 8.08376 15.5711C8.47429 15.1805 8.47429 14.5474 8.08376 14.1569L2.42691 8.5L8.08376 2.84315C8.47429 2.45262 8.47429 1.81946 8.08376 1.42893C7.69324 1.03841 7.06007 1.03841 6.66955 1.42893L0.305588 7.79289ZM21.0127 7.5L1.0127 7.5V9.5L21.0127 9.5V7.5Z"
                                            fill="#DE202C"/>
                                    </svg>
                                    {{$category->title}}
                                </div>
                                @foreach($category->children as $childCategory)
                                    <li class="submenu2 dropdown">
                                        <div class="dropdown-row">
                                            <a class="dropdown-toggle" href="{{route('catalog.category',$childCategory)}}">{{$childCategory->title}}
                                                <span class="caret"></span>
                                            </a>
                                            @if(count($childCategory->children))
                                                <div class="arrow-zone">
                                                    <span class="dropdown-arrow"></span>
                                                </div>
                                            @endif
                                        </div>
                                        @if(count($childCategory->children))

                                            <ul class="dropdown-menu mobile-catalog__sub">
                                                <div class="submenu2">
                                                    <svg width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.305588 7.79289C-0.0849361 8.18342 -0.0849361 8.81658 0.305588 9.20711L6.66955 15.5711C7.06007 15.9616 7.69324 15.9616 8.08376 15.5711C8.47429 15.1805 8.47429 14.5474 8.08376 14.1569L2.42691 8.5L8.08376 2.84315C8.47429 2.45262 8.47429 1.81946 8.08376 1.42893C7.69324 1.03841 7.06007 1.03841 6.66955 1.42893L0.305588 7.79289ZM21.0127 7.5L1.0127 7.5V9.5L21.0127 9.5V7.5Z"
                                                            fill="#DE202C"/>
                                                    </svg>
                                                    {{$childCategory->title}}
                                                </div>
                                                @foreach($childCategory->children as $subCategory)
                                                    <li class="submenu3">
                                                        <a href="{{route('catalog.category',$subCategory)}}">{{$subCategory->title}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- BEGIN navigation -->
        <div class="navigation">
            <div class="container">
                <div class="menu submenu" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
                    <ul class="nav navbar-nav">
                        <li class="submenu1 dropdown active">
                            <a class="dropdown-toggle" href="{{route('catalog')}}">Каталог
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($menu as $category)
                                    <li class="submenu2 dropdown">
                                        <a class="dropdown-toggle" href="{{route('catalog.category',$category)}}">{{ $category->title }}
                                            <span class="caret"></span>
                                        </a>
                                        @if(count($category->children))
                                            <ul class="dropdown-menu">
                                                @foreach($category->children as $childCategory)
                                                    <li class="submenu3 dropdown">
                                                        <a class="dropdown-toggle" href="{{route('catalog.category',$childCategory)}}">{{ $childCategory->title }}
                                                            <span class="caret"></span>
                                                        </a>
                                                        @if(count($childCategory->children))
                                                            <ul class="dropdown-menu">
                                                                @foreach($childCategory->children as $subCategory)
                                                                    <li class="submenu4">
                                                                        <a href="{{route('catalog.category',$subCategory)}}">{{ $subCategory->title }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                    </ul>
                    <ul class="">
                        @foreach($menu as $category)
                            @if($loop->iteration < 4)
                                <li class="@if(str_contains($_SERVER['REQUEST_URI'], $category->slug)) active @elseif($loop->first) first @elseif($loop->last) last @endif">
                                    <a href="{{route('catalog.category',$category) }}">{{ $category->title }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @include('layouts.partials.search')
            </div>
        </div>
        <!-- END navigation -->
        <div class="@yield('main_page_css_class')">
            <div class="container">
                <ol class="breadcrumb">
                    @yield('breadcrumb_items')
                </ol>
                @yield('mainblock')
            </div>
            @yield('content')
        </div>
    </div>
    <!-- BEGIN footer -->
    <footer itemscope itemtype="http://schema.org/WPFooter" class="footer">
        <div class="footer-contacts" itemscope itemtype="http://schema.org/Place">
            <div class="container">
                <div class="content">
                    <div class="image">
                        <img src="{{ asset('images/footer-contacts.png') }}" alt="компания ООО «Фатом»">
                    </div>
                    <div class="address">
                        @php $address = implode('<br>', explode(',', $active->address, 2)) @endphp
                        <p class="icon" itemprop="streetAddress"> @php echo htmlspecialchars_decode($address) @endphp </p>
                    </div>
                    <div class="mail">
                        <p class="icon"><a href="mailto:{{ $settings->email }} ">{{ $settings->email }} </a></p>
                    </div>
                    <div class="phone">
                        <a href="tel:{{ $active->tel }}" class="mgo-number" itemprop="telephone">{{ $active->tel }}</a>
                    </div>
                    <div class="callback">
                        <a href="#" data-toggle="modal" data-target=".modal-callback">Заказать звонок</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-navigation">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3">
                        <div class="menu menu-main">
                            <div class="menu-heading">
                                Меню
                            </div>
                            <div class="menu-list">
                                <ul class="">
                                    <li class="first">
                                        <a href="{{route('home')}}">Главная</a>
                                    </li>
                                    <li>
                                        <a href="{{route('services')}}">Услуги</a>
                                    </li>
                                    <li>
                                        <a href="{{route('about')}}">О компании</a>
                                    </li>
                                    <li>
                                        <a href="{{route('delivery')}}">Доставка</a>
                                    </li>
                                    <li class="last">
                                        <a href="{{route('contacts')}}">Контакты</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9">
                        <div class="menu menu-catalog">
                            <div class="menu-heading">
                                Каталог
                            </div>
                            <div class="row">
                                @foreach($menu as $category)
                                    @if($loop->iteration < 4)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="heading" itemprop="name">
                                                {{ $category->title }}
                                            </div>
                                            <div class="menu-list">

                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-info">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="copy">
                            © 2021 - Фатом
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="politics">
                            <a href="/policy">Политика конфиденциальности</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- END footer -->
</div>
<!-- END out -->

<a href="#out" class="arrow-up scroll"></a>

<!-- BEGIN modal-callback -->
<div class="modal modal-callback fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-header">
                <div class="modal-title">Заказать звонок</div>
            </div>
            <div class="modal-body">
                <form class="callback_form ajax_form" method="post" action="/modal" name="callbackform" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="domain" name="domain" value="{{ $active->domain }}">
                    <div class="form-group">
                        <input required type="text" class="form-control" id="userNameCB" name="userNameCB" value="" placeholder="Имя *">
                        <span class="error_userNameCB"></span>
                    </div>
                    <div class="form-group">
                        <input required type="tel" class="form-control" id="userPhoneCB" name="userPhoneCB" value="" placeholder="Телефон *">
                        <span class="error_userPhoneCB"></span>
                    </div>
                    <div class="form-group">
                        <textarea required class="form-control" id="userTextCB" name="userTextCB" value="" placeholder="Текст заявки"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button type="submit" name="submitCB" id="submitCB" class="btn btn-primary">Отправить</button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-file">
                                <a href="#" class="selectlink" for="file">Прикрепить файл <i></i></a>
                                <input type="file" name="uploadCB" id="file" onchange="getName(this);">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-personal">
                                    Нажимая кнопку «Отправить», я даю свое согласие на обработку моих <a href="/policy">персональных данных</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="af_action" value="727504469bfebe8e50f0eee906c608a5"/>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END modal-callback -->

<!-- BEGIN quick_buy -->
<div class="modal quick_buy fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-header">
                <div class="modal-title">Заказ в один клик</div>
            </div>
            <div class="modal-body">
                <div class="quick_buy" id="quick_buy">
                    <form class="callback_form ajax_form af_quick_buy quick_buy-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" class="qb-input" name="workemail">
                        <input type="hidden" class="qb-input" name="pagetitle" value="Купить Алюминиевая катанка 9,5 мм А5Е в {{ $active->domain_city_text }} ⭐ — ООО ФАТОМ">
                        <input type="hidden" class="qb-input" name="product_id" value="189156">
                        <input type="hidden" class="qb-input" name="price" value="208">
                        <input type="hidden" class="qb-input" name="url_page" value="https://ooofatom.ru/kupit-alyuminievaya-katanka-9,5-mm-a5e-v-⭐-—-ooo-fatom.html">

                        <div class="form-group">
                            <input type="text" class="qb-input form-control" placeholder="Имя *" name="receiver">
                        </div>
                        <div class="form-group">
                            <input type="tel" class="qb-input form-control" placeholder="Телефон *" name="phone">
                        </div>


                        <div class="quick_buy-info">
                            <p>Заполните форму и наши менеджеры свяжутся с вами в течение часа.</p>
                            <br/>
                            <button type="submit" class="button btn btn-primary">Заказать</button>
                        </div>

                        <input type="hidden" name="af_action" value="d42462e1126579e3039f3437916a3f26"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END modal-callback -->

<!-- MODAL REGIONS -->
<div class="modal fade" id="cfCity" tabindex="-1" role="dialog" aria-labelledby="cfCityLabel">
    <div class="modal-dialog mcity" role="document">
        <div class="modal-content mcity">
            <div class="modal-header mcity">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-title mcity" id="cfCityLabel">Выберите город</div>
            </div>
            <div class="modal-body mcity">
                <div class="form-horizontal">
                    <div class="form-group">
                        <input type="text" name="query" placeholder="Введите название" class="form-control" id="cfCitySearch"/>
                    </div>
                    <div class="text-danger" id="cfCityError">По данному запросу ни одного города не найдено!</div>
                </div>
                <ul class="list-unstyled cfcity_list">
                    @foreach($domains as $domainKey => $domainValue)
                        <li><a href="http://{{ $domainValue->domain }}" data-city="{{ $domainKey }}">{{ $domainValue->domain_city }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL REGIONS -->

<!-- BEGIN modal-order -->
<div class="modal modal-order fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-header">
                <div class="modal-title">Сделать заказ</div>
            </div>
            <div class="modal-body">
                <div class="product-name"></div>
                <form class="order_form ajax_form" method="post" action="kupit-alyuminievaya-katanka-9,5-mm-a5e-v-⭐-—-ooo-fatom.html" name="orderform" enctype="multipart/form-data">
                    <input type="hidden" name="pagename" value="Купить Алюминиевая катанка 9,5 мм А5Е в {{ $active->domain_city_text }} ⭐ — ООО ФАТОМ">
                    <input type="hidden" name="pageurl" value="https://ooofatom.ru/kupit-alyuminievaya-katanka-9,5-mm-a5e-v-⭐-—-ooo-fatom.html">
                    <input type="text" class="form-control hidden product" hidden name="product" id="">
                    <div class="form-group">
                        <input type="text" class="form-control" id="userNameOR" name="userNameOR" value="" placeholder="Имя *">
                        <span class="error_userNameOR"></span>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control" id="userPhoneOR" name="userPhoneOR" value="" placeholder="Телефон *">
                        <span class="error_userPhoneOR"></span>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="userMailOR" name="userMailOR" value="" placeholder="E-mail">
                        <span class="error_userMailOR"></span>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="userTextOR" name="userTextOR" value="" placeholder="Текст заявки"></textarea>
                    </div>
                    <input type="text" name="last_name" class="last_name" value="">
                    <input type="text" name="workemail" class="workemail" value="">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button type="submit" name="submitOR" id="submitOR" class="btn btn-primary">Отправить</button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-personal">
                                    Нажимая кнопку «Отправить», я даю свое согласие на обработку моих <a href="politika-konfidencialnosti.html">персональных данных</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="af_action" value="7fb050b2d8debba664a47fb4f5a2878a"/>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END modal-order -->

<!-- BEGIN cookie -->
<div class="cookie">
    <div class="container">
        <div class="cookie-content">
            <div class="text">
                Используя наш сайт, вы принимаете условия, согласно которым мы используем cookie-файлы для анализа данных и создания контента (в том числе и рекламного) на основе ваших интересов. Узнайте больше в разделе политика cookie.
            </div>
            <div class="button">
                <a href="#" class="btn btn-primary">Я согласен</a>
            </div>
        </div>
    </div>
</div>

<div class="lines"><span></span><span></span><span></span><span></span><span></span></div>
<ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div>

@include('layouts.partials.scripts',['glav'=>true])

</body>
</html>

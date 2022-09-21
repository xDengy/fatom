@extends('layouts.main')

@section('breadcrumb_items')
    <li class="breadcrumb-item"><a href="/">Главная</a></li>
    <li class="breadcrumb-item active">Контакты</li>
@endsection

@section('seo')
    <title>{{$seo->title}}</title>
    <meta name="description" content="{{$seo->description}}">
    <meta name="keywords" content="{{$seo->keywords}}">
@endsection

@section('main_page_css_class')
    page contacts
@endsection

<?php $baseImagePath = asset('images/static/contacts') ?>
@section('content')
    <h1 class="title">Контакты</h1>
    <div class="contacts-positions">
        @if($contacts)
            <ul>
                @foreach($contacts as $key => $contact)
                    <li class="contact">
                        <div class="contact-option image"><img src="{{ $contact->image_path }}"
                                                               alt="компания ООО «Фатом»"></div>
                        <div class="contact-option city">
                            <div class="heading">Город</div>
                            <div class="value">{{ $contact->city }}</div>
                        </div>
                        <div class="contact-option address">
                            <div class="heading">Адрес</div>
                            @php $addressAr = explode(', ', $contact->address, 2); $address = implode('<br>', $addressAr) @endphp
                            <div class="value"> @php echo html_entity_decode($address) @endphp </div>
                        </div>
                        <div class="contact-option phone">
                            <div class="heading">Телефон</div>
                            <div class="value">
                                <a href="tel:{{ $contact->tel }}" class="mgo-number-kda" itemprop="telephone">
                                    {{ $contact->tel }}
                                </a>
                            </div>
                        </div>
                        <div class="contact-option map">
                            <a data-fancybox data-options='{" iframe" : {"css" : {"width" : "80%", "height" : "80%"}}}'
                               href="{{ $contact->geo }}">Показать
                            на карте</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection

@section('subcontent')
    <div class="cooperation">
        <div class="container">
            <div class="cooperation-content">
                <div class="image" style="background: url(/images/cooperation.jpg);">
                </div>
                <div class="form">
                    <div class="form-heading">
                        Хотите сотрудничать?
                    </div>
                    <form class="contacts_form ajax_form" method="post" action="kontakty.html" name="contactsform" enctype="multipart/form-data">
                        <input type="hidden" name="pagename" value="Контакты">
                        <input type="hidden" name="pageurl" value="https://ooofatom.ru/kontakty.html">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="userName" name="userName" value="" placeholder="Имя *">
                                    <span class="error_userName"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="tel" class="form-control" id="userPhone" name="userPhone" value="" placeholder="Телефон *">
                                    <span class="error_userPhone"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="userText" name="userText" value="" placeholder="Комментарий"></textarea>
                        </div>
                        <input type="text" name="last_name" class="last_name" value="">
                        <input type="text" name="workemail" class="workemail" value="">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4">
                                    <div class="form-group form-file">
                                        <a href="#" class="selectlink" for="upload">Прикрепить файл <i></i></a>
                                        <input type="file" name="upload" id="file" onchange="getName(this);">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4">
                                    <div class="form-group">
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Отправить</button>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-12 col-xl-4">
                                    <div class="form-group">
                                        <div class="form-personal">
                                            Нажимая кнопку «Отправить», я даю свое согласие на обработку моих <a href="politika-konfidencialnosti.html">персональных данных</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" name="af_action" value="1a513b58c4b4980daf50ffa475533afb">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/fancybox/fancybox.js"></script>
@endsection


@section('css')
    <link rel="stylesheet" href="/css/fancybox/fancybox.css">
@endsection

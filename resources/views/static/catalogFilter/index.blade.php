@extends('layouts/main')

@section('breadcrumb_items')
    {{\Diglactic\Breadcrumbs\Breadcrumbs::render('catalog.category',$category)}}
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
    <meta name="description" content="{{$seoData['description']}}">
    <meta name="keywords" content="{{$seoData['keywords']}}">
@endsection

@section('main_page_css_class')
    page products
@endsection

<?php $baseImagePath = asset('images/static/catalog2')?>
@section('content')

    <h1 class="sf_h1">{{$seoData['title']}}</h1>
    <div class="subtitle"></div>
    <ul class="catalogItems">
        @if(count($category->siblings))
            @foreach($category->siblings as $sibling)
                <li class="@if(url()->current() == route('catalog.filter',$sibling)) active @endif">
                    <a href="{{route('catalog.filter',$sibling)}}">{{$sibling->title}}</a>
                </li>
            @endforeach
        @endif
    </ul>

    <div class="selected" id="mse2_selected" style="display: block">
        @foreach($selected as $key => $selectedOptions)
            @foreach($selectedOptions as $selectedOption)
                <div class="mse2_selected_link">
                    <em class="selected-value filter-off" data-filter="{{$key}}={{str_replace(' ','~',$selectedOption)}}">{{$selectedOption}}</em>
                </div>
            @endforeach
        @endforeach
    </div>
    <div class="flex-catalog msearch2" id="mse2_mfilter">
        <div class="sidebar">
            <div class="sidebar-buttons">
                <a href="#" class="btn btn-primary btn-filter">Фильтр каталога</a>
            </div>
            <!-- BEGIN catalog-filter -->
            <div class="catalog-filter">
                <div class="heading">
                    Фильтры по параметрам
                </div>
                <div class="sections">
                    <form action="/" id="mse2_filters">
                        @csrf
                        <div>
                            @foreach($filters as $key => $filter)
                                @if($filter)
                                    <fieldset id="mse2_msoption|{{ $key }}">
                                        <div class="section open">
                                            <div class="section-name filter_title">
                                                <span>{{ $filter['title'] }}</span>
                                            </div>
                                            <div class="section-content" style="display: block;">
                                                <div class="list">
                                                    @if($key == 'price')
                                                        @php
                                                            $minSet = $min = min($filter['values']);
                                                            $maxSet = $max = max($filter['values']);
                                                        @endphp
                                                        @if($key == 'price')
                                                            @php
                                                                $min = $filter['min'];
                                                                $max = $filter['max'];
                                                            @endphp
                                                            <div class="slider-values mse2_number_inputs">
                                                                <div class="value">
                                                                    <input type="text" name="{{$key}}[]" id="mse2_ms|price_0" value="{{$minSet}}" data-current-value="{{$minSet}}" class="integer" data-original-value="{{$min}}" data-decimal="0">
                                                                </div>
                                                                <div class="value">
                                                                    <input type="text" name="{{$key}}[]" id="mse2_ms|price_1" value="{{$maxSet}}" data-current-value="{{$maxSet}}" class="integer" data-original-value="{{$max}}" data-decimal="0">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="filter-range" data-name="{{$key}}" data-min="{{$min}}" data-current-min="{{$minSet}}" data-current-max="{{$maxSet}}" data-max="{{$max}}"></div>
                                                    @else
                                                        <ul>
                                                            @foreach($filter['values'] as $k => $title)
                                                                <li class="line-{{ $k }}">

                                                                    @php
                                                                        $checked =  (isset($selected[$key]) && in_array($title,$selected[$key]));
                                                                        $disabled = !in_array($title,$filter['available'])?'disabled':'';
                                                                    @endphp
                                                                    <input type="checkbox" {{ $disabled }} class="filter-input" name="{{ $key }}[]"
                                                                           @if($checked) checked @endif  id="mse2_msoption|{{ $key }}_{{ $k }}"
                                                                           value="{{ str_replace(' ','~',$title) }}">
                                                                    <label for="mse2_msoption|{{ $key }}_{{ $k }}"
                                                                           class="filter-label {{$disabled}}">{{ $title }}</label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                @endif
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between" style="margin-top:35px;">
                            @unless(empty($selected) && empty($filters['price']['values']))
                                {{--<button type="submit" class="btn btn-reset btn-primary" style="margin: 0">Отправить</button>--}}
                                <button type="reset" class="btn btn-light btn-reset" style="margin: 0">Сбросить</button>
                            @endunless
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="catalog-content">
            @if(count($products))
            <div id="mse2_sort" class="span5 col-md-5 sort-prod">
                Сотрировать по:
                <?php
                $url = url()->current() . '?';
                $params = request()->all();
                $sort = $dir = request('sort');

                if ($sort == 'desc') {
                    $sort = 'asc';
                } else {
                    $sort = 'desc';
                }
                $params['sort'] = $sort;
                $q = [];
                foreach ($params as $key => $param) {
                    $q[] = $key . '=' . $param;
                }

                $url = $url . implode('&', $q);
                ?>
                <a href="{{$url}}" data-sort="price" data-dir="{{$dir}}" data-default="desc" class="sort">
                    Стоимости
                    <span></span>
                </a>
            </div>
            @endif
            <div class="catalog-products">
                <div class="table" id="mse2_results">
                    @forelse($products as $k => $product)
                        <div class="ms2_product product">
                            <div class="product-img">
                                <a href="{{route('product',$product)}}">
                                    <img src="{{$product->image_path}}" alt="{{$product->image_alt}}" title="{{$product->image_title}}">
                                </a>
                            </div>
                            <div class="product-info__block">
                                <div class="product-name">
                                    <a href="{{route('product',$product)}}">
                                        @php echo str_replace(config('domain.replace'),$active->domain_city_text, $product->title) @endphp
                                    </a>
                                </div>
                                <div class="product-info__other">
                                    @foreach(explode(';', $product->options) as $k => $opt)
                                        @if($k < 2)
                                            @php $exp = explode('=', $opt) @endphp
                                            @if(count($exp) > 1)
                                                <div class="product-info">
                                                    <div class="left-info">
                                                        {{ $exp[0] }}
                                                    </div>
                                                    <div class="right-info">
                                                        {{ $exp[1] }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                                <div class="product-price">
                                <span class="price">
                                    {{ $product->price_title }}
                                </span>
                                </div>
                                {{--                                <form method="post" class="ms2_form product-order">--}}
                                {{--                                    <input type="hidden" name="id" value="{{ $product->id }}">--}}
                                <button class="btn btn-primary" type="button" name="ms2_action" data-add-to-cart value="{{route('cart.add',$product)}}">
                                    <span class="displayPC">В корзину</span>
                                    <span class="displayMOB">+</span>
                                </button>
                                {{--                                </form>--}}
                            </div>
                        </div>
                    @empty
                        <h2 class="title">В данной категории пока нет товаров</h2>
                    @endforelse
                </div>
            </div>
            {{$products->links('static.catalogFilter.pagination')}}
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/nouislider/nouislider.min.css') }}">
    <style>
        .filter-range,
        .filter-range .noUi-handle {
            box-shadow: none;
        }

        /* Hide markers on slider handles */
        .filter-range .noUi-handle::before,
        .filter-range .noUi-handle::after {
            display: none;
        }

        .filter-range {
            margin: 30px 14px 14px;
            border: 0;
            border-radius: 0;
            background: #dfdfdf;
            height: 5px;
        }

        .filter-range .noUi-connect {
            background: #e11f2c;
        }

        .filter-range .noUi-handle {
            height: 28px;
            width: 28px;
            border-radius: 50%;
            border: 3px solid #fff;
            background: #e11f2c;
            top: -4px;
            margin-left: -14px;
            margin-top: -8px;
            font-size: 12px;
            color: #999;
            font-family: "Roboto", sans-serif;
            font-weight: 400;
        }

        .selected {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 3px;
            margin-bottom: 20px;
        }

        .selected .mse2_selected_link {
            display: flex;
            flex-direction: row;
            font-size: 12px;

            justify-content: space-between;
        }

        .selected .selected-value {
            width: auto;
            height: auto;
        }

        .selected-text {
            display: flex;
            align-items: center;
            flex-direction: row;
            gap: 10px;
        }

        .selected-title {
            font-weight: bold;

        }

        .filter-off {
            border-radius: 0;
            display: flex;
            width: 20px;
            height: 20px;
            background-color: #e11f2c;
            justify-content: center;
            align-items: center;
            flex: 0 0 auto;
            color: #fff;
        }

        .filter-off:active, .filter-off:focus {
            outline: none;
        }

    </style>
@endsection

@section('js')
    <script src="{{asset('vendor/nouislider/nouislider.min.js')}}"></script>
    <script>
        $('.filter-input').on('change', e => {
            let filters = {};
            let checkedFilters = document.querySelectorAll("#mse2_filters input:checked[class='filter-input']")
            let queryString = []
            let formData = new FormData(document.getElementById('mse2_filters'))

            if (checkedFilters.length) {
                checkedFilters.forEach(item => {
                    let filterName = item.name.replace('[]', '')
                    if (filters.hasOwnProperty(filterName)) {
                        filters[filterName].push(item.value)
                    } else {
                        filters[filterName] = []
                        filters[filterName].push(item.value)
                    }
                })
            }

            for (name in filters) {
                queryString.push(`${name}=${filters[name].join(',')}`)
            }
            queryString = '/?' + queryString.join('&')
            let url = window.location.pathname + queryString
            var count = 0
            fetch(window.location.pathname, {
                method: 'post',
                body: formData,
            }).then(response => response.json()).then(json => setTooltip(e.target, json.count, url))
            return
        })

        $('[type="reset"]').on('click', () => {
            window.location.href = window.location.href.split('?')[0]
        })

        let ranges = document.querySelectorAll('.filter-range')
        let selectedBtns = document.querySelectorAll('.filter-off')
        let sliderValues = document.querySelectorAll('.list .slider-values input')

        if (sliderValues.length) {
            sliderValues.forEach((sliderValue, i) => {
                let values = [null, null]
                let idx = i
                sliderValue.addEventListener('change', (e) => {
                    values[i] = e.target.value
                    let slider = e.target.closest('.list').querySelector('.filter-range')
                    slider.noUiSlider.set(values)
                })
            })
        }
        if (ranges.length > 0) {
            ranges.forEach(range => {
                let min = parseInt(range.dataset.min)
                let max = parseInt(range.dataset.max)
                let minSet = parseInt(range.dataset.currentMin)
                let maxSet = parseInt(range.dataset.currentMax)
                noUiSlider.create(range, {
                    start: [minSet, maxSet],
                    connect: true,
                    step: 5,
                    range: {
                        'min': min,
                        'max': max
                    }
                });
                range.noUiSlider.on('update', function (values, handle) {
                    let sliderValues = range.closest('.list').querySelectorAll('.value input')
                    sliderValues[handle].value = parseInt(values[handle])
                });
                range.noUiSlider.on('set', function (values, handle, intValues) {
                    queryString = `${range.dataset.name}=${intValues.map(val => parseInt(val)).join(',')}`
                    if (window.location.href.includes('price')) {
                        console.log(window.location.href.replace(/price=\d+,\d+/, queryString))
                        window.location.href = window.location.href.replace(/price=\d+,\d+/, queryString)
                        return
                    } else {
                        if (!window.location.href.includes('?')) {
                            queryString = '/?' + queryString
                        } else {
                            queryString = '&' + queryString
                        }
                    }
                    window.location.href = window.location.href + queryString
                });

            })
        }
        if (selectedBtns.length > 0) {
            selectedBtns.forEach(btn => btn.addEventListener('click', e => {
                let [filterTitle, filterValue] = e.target.dataset.filter.split('=')
                let queryString = decodeURI(window.location.search.replace('?', ''))
                let filters = []
                queryString.split('&').forEach(filter => {
                    let [title, values] = filter.split('=')
                    filters[title] = values.split(',')
                })
                filters[filterTitle].splice(filters[filterTitle].indexOf(filterValue), 1)
                queryString = []
                for (let title in filters) {
                    if (filters[title].length > 0) {
                        queryString.push(title + '=' + filters[title].join(','))
                    }
                }
                queryString = queryString.join('&')
                if (queryString) {
                    window.location.href = window.location.pathname + "?" + queryString
                } else {
                    window.location.href = window.location.pathname
                }

            }))
        }

        function setTooltip(el, count, href) {
            let parentLi = el.closest('[class^="line-"]')
            let oldLink = document.querySelector('.filter-link')
            if (oldLink) {
                oldLink.remove()
            }
            let html = `<a class="filter-link" href="${href}">Found ${count} products</a>`
            parentLi.insertAdjacentHTML('beforeend', html)
        }
    </script>
@endsection

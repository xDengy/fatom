<li class="submenu{{$level}} dropdown">
    <a class="dropdown-toggle"
       href="{{route('catalog.category',$category)}}">{{ $category->name }}
        <span class="caret"></span>
    </a>
    @if($category->children)
        <ul class="dropdown-menu">
            @foreach($category->children as $k => $childCategory)
                @include('layouts.partials.dropdown-menu',[
                                               'category'=>$childCategory,
                                               'level' => $level++
                                               ])
            @endforeach
        </ul>
    @endif
</li>

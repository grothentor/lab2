@php
if (!isset($breadcrumbs)) {
    $breadcrumbs = [];
    $path = explode('/', url()->current());
    if (3 < count($path)) {
        $breadcrumbs[] = ['title' => __('Main page'), 'href' => route('mainPage')];
        $url = '/';
        for($i = 3; $i < count($path) - 1; $i++) {
            $url .= "$path[$i]/";
            $breadcrumbs[] = ['title' => __($path[$i]), 'href' => url($url)];
        }
    }
}
@endphp

@if(count($breadcrumbs))
    <div class="item-card-content-breadcrumb">
        <ol class="breadcrumb col-xs-11">
            @foreach($breadcrumbs as $url)
                <li><a href="{{ $url['href'] }}">{{ $url['title'] }}</a></li>
            @endforeach
            <li class="active">@yield('title')</li>
        </ol>
    </div>
@endif
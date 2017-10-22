@section('extra-links')
    <li>
        <a href="{{ URL::to('admin/realty-params/create') }}">
            @lang('messages.new', ['entity' => __('Realty param')])
        </a>
    </li>
    <li>
        <a href="{{ URL::to('admin/realty-params/create-realty-type') }}">
            @lang('messages.new', ['entity' => __('Realty type')])
        </a>
    </li>
@endsection
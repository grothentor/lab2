@extends('layouts.app')

@section('title', __('messages.new', ['entity' => __('Realty param')]))

@section('content')  

    @include('admin.realty-params.navigation')
    
    {{ Form::open(array('url' => 'admin/realty-params/')) }}

        <div class="form-group">
            {{ Form::label('table', __('type')) }}
            {{ Form::select('table', $tables, Request::input('table'), array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('title', __('title')) }}
            {{ Form::text('title', Request::input('title'), array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('uk_title', __('uk_title')) }}
            {{ Form::text('uk_title', Request::input('uk_title'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit(__('messages.create', ['entity' => __('Realty param')]), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection
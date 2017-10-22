@extends('layouts.app')

@section('title', __('messages.new', ['entity' => __('Realty type')]))

@section('content')  

    @include('admin.realty-params.navigation')
    
    {{ Form::open(array('url' => 'admin/realty-params/create-realty-type')) }}

        <div class="form-group">
            {{ Form::label('parent_id', __('Realty type')) }}
            {{ Form::select('parent_id', $realtyTypes, Request::input('parent_id'), array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('yrl_realty_type_id', __('Yrl realty type')) }}
            {{ Form::select('yrl_realty_type_id', $yrlTypes, Request::input('yrl_realty_type_id'), array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('title', __('title')) }}
            {{ Form::text('title', Request::input('title'), array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('uk_title', __('uk_title')) }}
            {{ Form::text('uk_title', Request::input('uk_title'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit(__('messages.create', ['entity' => __('Realty type')]), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection
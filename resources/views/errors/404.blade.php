@extends('layouts.app')
@php($breadcrumbs = [])
@section('title', __('Page don\'t found'))

@section('content')
    <div class="new-building-cap">
        <div class="container">
            <div class="new-building-cap__wrapper">
                <div class="error-bg__wrapper">
                    <div class="error-bg">404</div>
                    <div>@lang('messages.error404')</div>
                </div>
            </div>
        </div>
    </div>
@endsection

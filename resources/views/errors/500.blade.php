@php($exception = isset($exception) ? $exception : new Exception('test exception'))
@extends('layouts.app')
@php($breadcrumbs = [])

@section('title', __('messages.error500'))

@section('content')
    <div class="for-header"></div>
    <div class="new-building-cap">
        <div class="container">
            <div class="new-building-cap__wrapper">
                <div class="error-bg__wrapper">
                    <div class="error-bg">500</div>
                    <div>@lang('messages.error500')</div>
                </div>
            </div>
        </div>
    </div>
@endsection

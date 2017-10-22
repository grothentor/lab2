@extends('layouts.app')

@php($breadcrumbs = [])
@section('title', __('Access denied'))

@section('content')
    <div class="for-header"></div>
    <div class="new-building-cap">
        <div class="container">
            <div class="new-building-cap__wrapper">
                <div class="error-bg__wrapper">
                    <div class="error-bg">403</div>
                    <div>@lang('messages.error403')</div>
                </div>
            </div>
        </div>
    </div>
@endsection

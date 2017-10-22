@php($exception = isset($exception) ? $exception : new \Illuminate\Foundation\Http\Exceptions\MaintenanceModeException(5, 10))
@extends('layouts.app')
@php($breadcrumbs = [])

@section('title', __('maintenance'))

@section('content')
    <div class="for-header"></div>
    <div class="new-building-cap">
        <div class="container">
            <div class="new-building-cap__wrapper">
                <div class="error-bg__wrapper">
                    <div class="error-bg">503</div>
                    <div>@lang('messages.error503', ['time' => $exception->retryAfter])</div>
                </div>
            </div>
        </div>
    </div>
@endsection

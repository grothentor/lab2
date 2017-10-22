@extends('layouts.app')

@section('title', __('Server Error'))

@section('content')
    <div class="for-header"></div>
    <h1>@lang($exception->getMessage())</h1>
@endsection
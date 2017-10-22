@extends('layouts.app')
@section('title', __('Login'))

@php($displayErrors = false)

@section('content')
    <main>
        <section class="personal-cab-login">
            <div class="container">
                <h2>@lang('Login')</h2>
                <form class="personal-cab-login-form" action="{{ route('login') }}" method="post">
                    <fieldset>
                        {{ csrf_field() }}
                        <div class="col-xs-12 col-sm-6 login">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="@lang('E-Mail Address')" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <span class="error">{{ $errors->first('email') }}</span>
                                    </span>
                                @endif
                                <input type="password" name="password" required class="form-control" placeholder="@lang('Password')">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <span class="error">{{ $errors->first('password') }}<span class="error"></span></span>
                                    </span>
                                @endif
                                <div class="button-group">
                                    <button type="submit" class="enter">@lang('Login')</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </section>
    </main>
@endsection

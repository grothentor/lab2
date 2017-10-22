@extends('layouts.app')

@section('title', __('Fix errors'))

@section('content')

    @if(session('admin_messages') && session('admin_messages')->count())
        <div ng-controller="adminCtrl" class="container-fluid">
            <div class="alert alert-warning row delete-all-btn">
                <div class ="col-sm-4 alert btn btn-danger center-block" ng-click="deleteAllMessages()">
                    Удалить все
                </div>
            </div>
            <input type="checkbox" ng-model="askEdit" id="ask-edit">
            <label for="ask-edit">Спрашивать о редактировании</label>
            @foreach (session('admin_messages') as $adminMessage)
                <div class="alert alert-warning row admin-message">
                    <div class ="col-sm-8">
                        <strong>{{ $adminMessage->created_at }}</strong><br>
                        {{ $adminMessage->message }}
                    </div>
                    <div class="col-sm-2 alert btn btn-primary" ng-click="autoFixMessage($event, {{ $adminMessage->id }})">
                        Добавить в БД
                    </div>
                    <div class="col-sm-2 alert btn btn-danger" ng-click="deleteMessage($event, {{ $adminMessage->id }})">
                        Удалить
                    </div>
                </div>
            @endforeach
        </div>
    @else
        Ошибок не зафиксированно.
    @endif

@endsection
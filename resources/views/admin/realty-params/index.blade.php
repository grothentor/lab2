@extends('layouts.app')

@section('title', __('realty-params'))
@php($realtyTypeTableName = \App\RealtyType::getTableName())
@section('content')

    @include('admin.realty-params.navigation')

    <table class="table table-striped table-bordered" ng-controller="editRealtyParamsCtrl">
        <thead>
        <tr>
            <td colspan="2">@lang('id')</td>
            <td>@lang('title')</td>
            <td>@lang('uk_title')</td>
            <td>@lang('alternatives')</td>
        </tr>
        </thead>
        <tbody ng-init="init('{{ json_encode($yrlTypes) }}')">
        @foreach($tables as $tableName => $table)
            @if($tableName === $realtyTypeTableName)
                @foreach($table as $realtyTypeId => $tableValues)
                    <tr>
                        <td colspan="5">{{ generateForeignKey($tableName, true) }}. {{ __(\App\RealtyType::getTypeById($realtyTypeId)) }}</td>
                    </tr>
                    @foreach($tableValues as $key => $value)
                        @include('admin.realty-params.table-row', ['isRealtyType' => true])
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td colspan="5">{{ generateForeignKey($tableName, true) }}</td>
                </tr>
                @foreach($table as $key => $value)
                    @include('admin.realty-params.table-row', ['isRealtyType' => false])
                @endforeach
            @endif
        @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
{{ Html::script(mix('js/editable.js')) }}
@endpush
@php(addJsTemplate('editable-array'))
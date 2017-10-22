<tr class="row-{{ $tableName }}-{{ $value->id }}">
    <td @if(!$isRealtyType)colspan="2"@endif>
        {{ $value->id }}
        <span class="glyphicon glyphicon-remove" ng-click="removeRealtyParam('{{ $tableName }}', {{ $value->id }})"></span>
    </td>
    @if($isRealtyType)
        <td ng-init="realtyTypes.{{ $tableName }}_{{ $value->id }} = {{ $value->yrl_realty_type_id ?? "''" }}">
            <ui-select remove-selected="false"
                       ng-model="realtyTypes.{{ $tableName }}_{{ $value->id }}"
                       title="@lang('Yrl realty type')"
                       theme="/views/ui-select"
                       ng-disabled="!yrlTypes.length"
                       on-select="changeYrlType('{{ $tableName }}', {{ $value->id }})">
                <ui-select-match placeholder="@lang('Yrl realty type')">
                    <span ng-bind-html="$select.selected.title || $select.selected"></span>
                </ui-select-match>
                <ui-select-choices
                        repeat="yrlType.id as yrlType in yrlTypes | propsFilter: {title: $select.search}">
                    <div ng-bind-html="yrlType.title | highlight: $select.search"></div>
                </ui-select-choices>
                <ui-select-no-choice></ui-select-no-choice>
            </ui-select>
        </td>
    @endif
    <td>
        <div editable-array
             array="'{{ json_encode([
                'title' => $value->getOriginal('title'),
                'id' => $value->id,
             ]) }}'"
             url="'/api/{{ $tableName }}'">
        </div>
    </td>
    <td>
        <div editable-array
             uk="true"
             array="'{{ json_encode([
                'title' => $value->uk_title,
                'id' => $value->id,
             ], JSON_HEX_APOS | JSON_HEX_QUOT) }}'"
             url="'/api/{{ $tableName }}'">
        </div>
    </td>
    <td>
        <div editable-array
            array="'{{ json_encode($value->alternatives->map(function ($alternative) {
                return [
                    'id' => $alternative->id,
                    'title' => $alternative->getOriginal('title'),
                ];
            })) }}'"
            url="'/api/{{ $tableName }}/{{ $value->id }}/alternatives'">
        </div>
    </td>
</tr>
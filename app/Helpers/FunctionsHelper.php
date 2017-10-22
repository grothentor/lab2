<?php
/**
 * js - templates array for preload on pages
 *
 * @param array $newJsTemplates
 */
function addJsTemplates(array $newJsTemplates) {
    foreach ($newJsTemplates as $jsTemplate)
        addJsTemplate($jsTemplate);
}

function addJsTemplate(string $jsTemplate) {
    $jsTemplatesPath = config('app.jsTemplatesPath');
    global $jsTemplates;
    if (null === $jsTemplates) $jsTemplates = [];
    $templatePath = "$jsTemplatesPath$jsTemplate";
    if (is_dir($templatePath)) {
        $folder = $jsTemplate;
        foreach (array_diff(scandir($templatePath), ['..', '.']) as $jsTemplate)
            addJsTemplate("$folder/$jsTemplate");
    } else {
        if (false === strpos($templatePath, '.html')) {
            $templatePath .= '.html';
            $jsTemplate .= '.html';
        }
        if (file_exists($templatePath) && !isset($jsTemplates[$jsTemplate])) {
            $jsTemplates[$jsTemplate] = $templatePath;
        }
    }
}

function generateForeignKey($tableName, $translated = false) {
    $extraForeign = [
        'realty_gases' => 'realty_gas_id',
        'bonuses' => 'bonuses',
        'assignments' => 'assignments',
    ];

    $foreign = isset($extraForeign[$tableName]) ? $extraForeign[$tableName] : str_finish(str_singular($tableName), '_id');
    return $translated ? __("js-messages.$foreign") : $foreign;
}

function generateTableClass($tableName) {
    $tableClasses = [
        'realty_gases' => 'RealtyGas',
    ];
    return 'App\\' . (isset($tableClasses[$tableName]) ? $tableClasses[$tableName] : studly_case(str_singular($tableName)));
}
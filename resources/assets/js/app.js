/**
 * Libs
 */
window.$ = window.jQuery = window.jquery = require('jquery');
require('../lib/angular/angular.min');
require('../lib/bootstrap/dist/js/bootstrap.min');
require('../lib/angular-bootstrap/ui-bootstrap.min');
require('../lib/angular-ui-select/dist/select.min');
require('../lib/angular-sanitize');

require('./scripts/scripts');

/**
 * Angular
 */
(function (){
    window.app = angular.module('App', ['ui.select', 'ngSanitize'],
        ['$locationProvider', ($locationProvider) => {
            $locationProvider.html5Mode({
                enabled: true,
                rewriteLinks: false
            });
        }]);
})();
require('./app/filters/propsFilter');

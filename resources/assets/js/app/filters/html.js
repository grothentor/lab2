(function () {
    app.filter('html', ['$sce', function ($sce) {
        return function(value) {
            return $sce.trustAsHtml(value);
        }
    }]);
})();
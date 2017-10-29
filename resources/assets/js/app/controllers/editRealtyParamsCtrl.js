/**
 * Created by grothentor on 9/29/17.
 */
(function() {
    app.controller('editRealtyParamsCtrl', ['$scope', '$http', '$window',
        function ($scope, $http, $window) {
            $scope.realtyTypes = {};
            $scope.yrlTypes = [];

            $scope.init = (jsonYrlTypes) => {
                $scope.yrlTypes = JSON.parse(jsonYrlTypes);
            };

            $scope.removeRealtyParam = (tableName, id) => {
                $http.delete(`/api/${tableName}/${id}?api_token=${$window.Laravel.user.api_token}`)
                    .then((response) => {
                        alert(response.data.success);
                        angular.element(`.row-${tableName}-${id}`).remove();
                    }, $window.errorsHandler);
            };

            $scope.changeYrlType = (tableName, realtyTypeId) => {
                let data = {
                    yrl_realty_type_id: $scope.realtyTypes[`${tableName}_${realtyTypeId}`],
                };
                $http.patch(`/api/${tableName}/${realtyTypeId}?api_token=${$window.Laravel.user.api_token}`, data)
                    .then((response) => {
                        //alert('saved');
                    }, $window.errorsHandler);
            };
        }]);
})();
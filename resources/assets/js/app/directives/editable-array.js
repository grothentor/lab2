(function () {
    app.directive('editableArray', ['$http', '$timeout', '$window', function ($http, $timeout, $window) {
        return {
            restrict: 'A',
            templateUrl: '/views/editable-array.html',
            replace: true,
            scope: {
                url: '=',
                array: '=',
                uk: '=?',
                deletable: '=?',
                creatable: '=?',
            },
            link: function ($scope) {
                if (void 0 === $scope.creatable) $scope.creatable = true;
                if (void 0 === $scope.uk) $scope.uk = false;
                if (void 0 === $scope.deletable) $scope.deletable = true;

                if (!$scope.editableArray) $scope.editableArray = [];
                if ($scope.array) $scope.editableArray = JSON.parse($scope.array);
                if (!Array.isArray($scope.editableArray)) {
                    $scope.editableArray = [$scope.editableArray];
                    $scope.creatable = false;
                    $scope.deletable = false;
                }

                $scope.editItem = (item) => {
                    endAllEditing();
                    item.editing = true;
                    item.oldTitle = item.title;
                    targetItemInput(item);
                };

                $scope.endEditing = (item, $event) => {
                    if ($event) {
                        $timeout($scope.endEditing, 150, true, item);
                        return;
                    }
                    if (item.editing) {
                        if (item.id) {
                            item.editing = false;
                            item.title = item.oldTitle;
                            delete(item.oldTitle);
                        } else {
                            deleteItem(item);
                        }
                    }
                };

                $scope.successEditing = (item, $event) => {
                    if (!$event || ($event && 'Enter' === $event.key)) {
                        if (item.title) {
                            let data = { };
                            data[$scope.getTitleAttribute()] = item.title;
                            if (item.id) {
                                $http.patch(`${$scope.url}/${item.id}`, data).then(response => saveResponse(response, item), $window.errorsHandler);
                            } else {
                                $http.post($scope.url, data).then(response => saveResponse(response, item), $window.errorsHandler);
                            }
                        } else {
                            $window.alert(Lang.get('js-messages.tooShort'));
                        }
                    } else {
                        if ($event && 'Escape' === $event.key) {
                            $scope.endEditing(item);
                        }
                    }
                };

                $scope.removeItem = (item) => {
                    endAllEditing();
                    if (item.id) {
                        $http.delete(`${$scope.url}/${item.id}`).then(response => deleteItem(item), $window.errorsHandler);
                    } else {
                        deleteItem(item);
                    }
                };

                $scope.addItem = () => {
                    endAllEditing();
                    let newItem = {
                        editing: true,
                        title: '',
                    };
                    $scope.editableArray.push(newItem);
                    targetItemInput(newItem);
                };

                $scope.getTitleAttribute = () => {
                    return ($scope.uk ? 'uk_' : '') + 'title';
                };

                let saveResponse = (response, oldItem) => {
                    if (response.data.success) {
                        $window.alert(response.data.success);
                        let itemIndex = $scope.editableArray.indexOf(oldItem);
                        let entity = generateEntity(response.data.entity);
                        if (-1 === itemIndex) {
                            $scope.editableArray.push(entity);
                        }
                        else $scope.editableArray[itemIndex] = entity;
                    }
                };

                let deleteItem = item => {
                    if ($scope.editableArray.includes(item)) {
                        let itemIndex = $scope.editableArray.indexOf(item);
                        $scope.editableArray.splice(itemIndex, 1);
                    }
                };

                let endAllEditing = () => {
                    $scope.editableArray.map(item => {
                        if (item.editing) $scope.endEditing(item);
                    })
                };

                let targetItemInput = (item) => {
                    $timeout(() => {
                        angular.element(`.edit-${ $scope.editableArray.indexOf(item) }`).focus();
                    }, 10);
                };

                let generateEntity = (fullEntity) => {
                    return {
                        id: fullEntity.id,
                        title: fullEntity[$scope.getTitleAttribute()],
                    }
                };
            }
        };
    }]);
})();
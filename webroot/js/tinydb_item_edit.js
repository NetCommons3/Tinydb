/**
 * Tinydb edit Javascript
 */
NetCommonsApp.controller('Tinydb',
    ['$scope', 'NetCommonsWysiwyg', '$filter',
      function($scope, NetCommonsWysiwyg, $filter) {
        /**
         * tinymce
         *
         * @type {object}
         */
        $scope.tinymce = NetCommonsWysiwyg.new({height: 280});

        $scope.writeBody2 = false;

        $scope.init = function(data) {
          if (data.TinydbItem) {
            $scope.tinydbItem = data.TinydbItem;
            if ($scope.tinydbItem.body2 !== null) {
              if ($scope.tinydbItem.body2.length > 0) {
                $scope.writeBody2 = true;
              }
            }
          }
        };

        $scope.tinydbItem = {
          body1: '',
          body2: '',
          publish_start: ''
        };
      }
    ]
);

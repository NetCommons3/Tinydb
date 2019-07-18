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
            $scope.tinydbEntry = data.TinydbItem;
            if ($scope.tinydbEntry.body2 !== null) {
              if ($scope.tinydbEntry.body2.length > 0) {
                $scope.writeBody2 = true;
              }
            }
          }
        };

        $scope.tinydbEntry = {
          body1: '',
          body2: '',
          publish_start: ''
        };
      }
    ]
);

// define angular module/app
var app = angular.module('app', ['ngRoute']);

// configure our routes
app.config(function($routeProvider) {
    $routeProvider
        // Home page
        .when('/', {
            templateUrl : 'views/main.html',
            controller  : 'mainController'
        })
        // Tag definition page
        .when('/tags', {
            templateUrl : 'views/tag-definitions.html',
            controller  : 'tagDefController'
        })
        .otherwise({
            redirectTo : '/'
        });
});

// create the controller and inject Angular's $scope
app.controller('mainController', function($scope) {
    // create a message to display in our view
    $scope.title = 'Home';
});

app.controller('tagDefController', function($scope) {
    $scope.title = 'Tag definitions';
});

// create angular controller and pass in $scope and $http
app.controller('formController', function($scope, $http) {

    // create a blank object to hold our form information
    // $scope will allow this to pass between controller and view
    $scope.formData = {};

    // process the form
    $scope.processForm = function() {
        $http({
            method: 'POST',
            url:    'process.php',
            data:   $.param($scope.formData),  // pass in data as strings
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
        })
        .success(function(data) {
            console.log(data);
            console.log(data.html);

            if (!data.success) {
                $scope.errorUrl = data.errors;
            } else {
                $scope.result = data.html;
                $scope.errorUrl = '';
            }
        });

    };
});
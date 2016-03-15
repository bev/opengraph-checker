// define angular module/app
var app = angular.module('app', []);

// create angular controller and pass in $scope and $http
var formController = function($scope, $http) {

    // create a blank object to hold our form information
    // $scope will allow this to pass between controller and view
    $scope.formData = {};

    // process the form
    $scope.processForm = function() {
        $http({
            method  : 'POST',
            url     : '../src/process.php',
            data    : $.param($scope.formData),  // pass in data as strings
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
        })
        .success(function(data) {
            console.log(data);

            // if (!data.success) {
            //     // if not successful, bind errors to error variables
            //     $scope.url = data.errors.url;
            // } else {
            //     // if successful, bind success message to message
            //     $scope.message = data.message;
            //                 $scope.url = '';
            // }
        });

    };

};
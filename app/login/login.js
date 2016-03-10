/*
* Purpose: To authenticate user
* Dependencies: scope, http, location, toaster
* Inputs: email, password
*/

var feedApp = angular.module('feedApp.login', ['ngRoute']).config(['$routeProvider', function($routeProvider) {
    
  $routeProvider.when('/', {
    templateUrl: 'login.html',
    controller: 'LoginCtrl'
  });
}]);



feedApp.controller('LoginCtrl', ['$scope', '$http',function($scope, $http) {

 
}]);

/*socialApp.controller('LoginCtrl', ['$scope', '$http', '$location', '$timeout', 'toaster', '$rootScope', function ($scope, $http, $location, $timeout, toaster, $rootScope) {
    $scope.submitForm = function() {
        var data = {
            email: $scope.email,
            password: $scope.password
        };
        // Sending http request to web server
        $http.post(basepath+'/webservice/index.php/Login/authenticateUser', data)
        .success(function(response){
            // setting all the fields blank
            $scope.email = '';
            $scope.password = '';

            if(response.response === true){
                $rootScope.isLoggedIn = 1;
                // displaying success message
                toaster.pop('success', "Success", "You have successfully logged in.Redirecting you in a while...");
                // redirection after 3 seconds
                $timeout(function(){
                    $location.path('/messages'); 
                },3000);
            }            
        })
        // displaying error message
        .error(function(response){
            toaster.pop('error', "Error", "Oops something went wrong. Please try again later.");
        });
    };
}]);*/
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


feedApp.controller('LoginCtrl', ['$scope', '$http', 'UserService','toaster', 
function(scope, $http, User,toaster) 
 { 

  scope.authenticate = function() {
  // configuration object
  var config = {url:'http://localhost/fa/service.php', method: 'POST', data:{action:'authenticateuser',username: scope.username, password: scope.password}}

  $http(config)
  .success(function(data, status, headers, config) { 
    if (data.status_message === 'success') {
      // succefull login
      User.isLogged = true;
      User.username = data.username;

      
    }
    else {
      User.isLogged = false;
      User.username = '';
      // create a toast with settings:
                toaster.pop({
                    type: 'error',
                    title: '',
                    body: "Email/Pwd is incorrect",
                    showCloseButton: true
                });

    }
  })
  .error(function(data, status, headers, config) {
    User.isLogged = false;
    User.username = '';
  });
}
}]);
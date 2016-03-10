/*
* Purpose: To register user
* Dependencies: scope, http, location, toaster
* Inputs: firstname, lastname, email, password
*/
var feedApp = angular.module('feedApp.register', ['ngRoute']).config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/', {
    templateUrl: 'registration.html',
    controller: 'RegistrationCtrl'
  });
}]);

feedApp.controller('RegistrationCtrl', ['$scope', '$http', '$location', 'toaster', function ($scope, $http, $location, toaster) {

    $scope.registerUser = function($form){ 
	if($form.$valid)
	{ 
		$http({
			method : "POST",
			data : {username:$scope.username, password:$scope.password, firstname: $scope.firstname, lastname: $scope.lastname, action: 'registeruser'},
			url : "http://183.182.84.84/MEAN/prasoon-rahul/app/web_services/service.php"
		}).then(function onComplete(response) {
			if(response.data.status_message == 'success')
			{
				// create a toast with settings:
				toaster.pop({
					type: 'success',
					title: '',
					body: response.data.post_result,
					showCloseButton: true
				});
		    }
		}, function onError(response) {
			// create a toast with settings:
				toaster.pop({
					type: 'success',
					title: '',
					body: "There has been some error processing your request",
					showCloseButton: true
				});
		});
		
	}
	return false;
    }
}]);
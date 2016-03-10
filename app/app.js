'use strict';

//SetbasePath
var basepath = 'http://localhost/feedapp/';

// Declare app level module which depends on views, and components
angular.module('feedApp', [
  'ngRoute',
  'toaster',
  'ngSanitize',
  'feedApp.login',
  'feedApp.register',
  //'feedApp.feeds',
  'ngMessages',
  'validation.match'
]).
config(['$routeProvider', function($routeProvider) {
   $routeProvider.
      /*when('/feeds', {
        templateUrl: 'app/feeds/feeds.html',
        controller: 'FeedsCtrl'
      }). */
      when('/login', {
        templateUrl: 'app/login/login.html',
        controller: 'LoginCtrl'
      }).
      when('/register', {
        templateUrl: 'app/registration/registration.html',
        controller: 'RegistrationCtrl'
      }).          
      otherwise({
        redirectTo: '/'
      });
}]);



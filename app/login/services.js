feedApp.factory('UserService', [function() {
  var loginObj = {
    isLogged: false,
    username: ''
  };
  return loginObj;
}]);
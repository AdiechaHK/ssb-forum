var app = angular.module('app', ['ngRoute']);

app.config(['$routeProvider', function($routeProvider) {

  var path = "../public/angular/views/";

  $routeProvider.
    when('/', { templateUrl: path + 'welcome.html'}).
    when('/dashboard', { templateUrl: path + 'dashboard.html'}).
    otherwise({ redirectTo: '/' });
}]);

app.service('Api', ['$http', function ($http) {

  var path = './api/';

  var queryString = function(json, all) {
    if (typeof all == "undefined") {
      all = false;
    }
    var list = Object.keys(json).map(function(key) {
      return key + "=" + json[key];
    }, []);
    return (all && list.length > 0 ? "?": "") + list.join("&");
  }

  this.create = function(model, data, callback) {
    $http.get(path + "create/" + model + queryString(data, true)).then(callback);
  }

  this.list = function(model, condition, callback) {
    if (typeof condition == "function") {
      callback = condition;
      condition = {};
    }
    $http.get(path + "get_list/" + model + queryString(condition, true)).then(callback);
  }

  this.get = function(model, id, callback) {
    $http.get(path + "get/" + model + "/" + id).then(callback);
  }

  this.remove = function (model, id, callback) {
    $http.get(path + "remove/" + model + "/" + id).then(callback);
  }

  this.login = function (data, callback) {
    $http.post(path + "login", data).then(callback);
  }

  this.register = function (data, callback) {
    $http.post(path + "register", data).then(callback);
  }

}]);

app.controller('WelcomeController', ['$scope', '$location', 'Api', function($scope, $location, Api) {
  
  $scope.batchList = [];
  $scope.title = "Login"

  var init = function() {
    $scope.testing = "Hello there !";

    Api.list('batch', function(res){
      $scope.batchList = res.data
    });
  }   

  init();

  $scope.login = function() {
    Api.login($scope.loginData, function (res) {
      if(res.data.status == "success") {
        $location.path('/dashboard');
      } else {
        alert(res.data.message);
      }
    });
  };

  $scope.register = function() {
    Api.register($scope.registrationData, function (res) {
      console.log(res.data);
    });
  };

}]);
var app = angular.module('app', ['ngRoute', 'ngCookies']);

var selfPath = function(extension) {
  var rex = /^http[s]{0,1}:\/\/[\w|.]+/;
  var path = $("#base-path").data('path');

  return (rex.test(path)? path.split(rex).join("") + extension: path + extension);
}

app.config(['$routeProvider', function($routeProvider) {

  var path = selfPath("public/angular/views/");

  $routeProvider
    .when('/', { templateUrl: path + 'welcome.html'})
    .when('/dashboard', { templateUrl: path + 'dashboard.html'})
    .when('/group/:id', { templateUrl: path + 'group.html'})
    .when('/members', { templateUrl: path + 'members.html'})
    .when('/message/:id', { templateUrl: path + 'message.html'})
    .otherwise({ redirectTo: '/' });
}]);


app.service('Api', ['$http', function ($http) {

  var path = selfPath('index.php/api/');

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

  this.all = function(model, condition, callback) {
    if (typeof condition == "function") {
      callback = condition;
      condition = {};
    }
    $http.get(path + "get_all/" + model + queryString(condition, true)).then(callback);
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

  this.messages = function(u1, u2, callback) {
    $http.get(path + "messages/" + u1 + "/" + u2).then(callback);
  }

}]);

app.filter('username', function() {
  return function(id, list) {
    return list.reduce(function(uName, user) {
      return user.id == id ? user.username: uName;
    }, "No name");
  };
});

app.controller('WelcomeController', [
  '$scope',
  '$location',
  '$cookies',
  'Api',
  function($scope, $location, $cookies, Api) {
  
  $scope.batchList = [];
  $scope.title = "Login"


  var init = function() {
    $scope.testing = "Hello there !";

    Api.list('batch', function(res){
      $scope.batchList = res.data
    });

    var user_cookies = $cookies.get('auth_user');
    if (typeof user_cookies != "undefined") {
      $location.path('/dashboard');
    }

  }   

  init();

  $scope.login = function() {
    Api.login($scope.loginData, function (res) {
      if(res.data.status == "success") {
        $cookies.put('auth_user', res.data.user);
        $location.path('/dashboard');
      } else {
        alert(res.data.message);
      }
    });
  };

  $scope.register = function() {
    Api.register($scope.registrationData, function (res) {
      if(res.data.status) {
        alert("Registed successfully. Now you can proceed with login.");
      } else {
        alert(res.data.message);
      }
    });
  };

}]);

app.controller('DashboardController', [
  '$scope',
  '$location',
  '$cookies',
  'Api',
  function($scope, $location, $cookies, Api) {

    $scope.groupList = [];

    var groupListing = function() {

      Api.list('group', {
        'batch': $scope.user.batch
      }, function (res) {
        console.log(res);
        $scope.groupList = res.data;
      });
    }

    var init = function() {
      var user_cookies = $cookies.get('auth_user');
      if (typeof user_cookies == "undefined") {
        $location.path('/');
      } else {
        $scope.user = JSON.parse(user_cookies);
      }
      $scope.header_url = selfPath('public/angular/views/header.html');
      $scope.tab = 'group';
      groupListing();
    }

    init();

    $scope.logout = function() {
      $cookies.remove('auth_user');
      $location.path('/');
    }

    $scope.addGroup = function() {
      var group = {
        'title': prompt("Enter new Group name:"),
        'description': prompt("Enter new Group description:"),
        'batch': $scope.user.batch
      }
      Api.create('group', group, function (res) {
        groupListing();
      });
    }

  }
]);

app.controller('GroupController', [
  '$scope',
  '$routeParams',
  '$location',
  '$cookies',
  'Api',
  function($scope, $routeParams, $location, $cookies, Api) {

    $scope.group;
    $scope.user;
    $scope.groupPostList = [];
    $scope.affectedMembers;

    var postListing = function(cb) {
      cb = (typeof cb == "undefined") ? function(){}: cb;
      Api.list('group_post', {
        'gid': $scope.group.id
      }, function (res) {
        $scope.groupPostList = res.data;
        cb();
      });
    };

    var init = function() {
      var user_cookies = $cookies.get('auth_user');
      if (typeof user_cookies == "undefined") {
        $location.path('/');
      } else {
        $scope.user = JSON.parse(user_cookies);
      }
      $scope.header_url = selfPath('public/angular/views/header.html');
      $scope.tab = 'group';
      Api.all('user', {'batch': $scope.user.batch }, function(res) {
        $scope.affectedMembers = res.data;
      });
      Api.get('group', $routeParams.id, function(res) {
        $scope.group = res.data;
        postListing();
      });
    };

    init();
   
    $scope.post = function() {

      $scope.newPost.uid = $scope.user.id;
      $scope.newPost.gid = $scope.group.id;

      Api.create('group_post', $scope.newPost, function(res) {
        $scope.newPost.text = "";
        postListing(function() {
          $("#post-text").focus();
        });
      });
    }

    $scope.logout = function() {
      $cookies.remove('auth_user');
      $location.path('/');
    }

  }
]);


app.controller('MembersController', [
  '$scope',
  '$location',
  '$cookies',
  'Api',
  function($scope, $location, $cookies, Api) {

    $scope.memberList;

    var memeberListing = function() { 
      Api.list('user', {'batch': $scope.user.batch }, function(res) {
        $scope.memberList = res.data;
      });
    };

    var init = function() {
      var user_cookies = $cookies.get('auth_user');
      if (typeof user_cookies == "undefined") {
        $location.path('/');
      } else {
        $scope.user = JSON.parse(user_cookies);
      }
      $scope.header_url = selfPath('public/angular/views/header.html');
      $scope.tab = 'member';
      memeberListing();
    }

    init();

    $scope.logout = function() {
      $cookies.remove('auth_user');
      $location.path('/');
    }
  }
]);

app.controller('MessageController', [
  '$scope',
  '$location',
  '$cookies',
  '$routeParams',
  'Api',
  function($scope, $location, $cookies, $routeParams, Api) {

    $scope.affectedMembers = [];

    $scope.user;
    $scope.friend;
    $scope.header_url;
    $scope.tab;
    $scope.messageList;

    var messageListing = function(cb) {
      cb = typeof cb == "undefined"? function(){}: cb;
      Api.messages($scope.user.id, $scope.friend.id, function(res) {
        $scope.messageList = res.data;
        cb();
      });
    };

    var init = function() {
      var user_cookies = $cookies.get('auth_user');
      if (typeof user_cookies == "undefined") {
        $location.path('/');
      } else {
        $scope.user = JSON.parse(user_cookies);
        $scope.affectedMembers.push($scope.user);
      }
      $scope.header_url = selfPath('public/angular/views/header.html');
      $scope.tab = 'member';
      Api.get('user', $routeParams.id, function(res) {
        $scope.friend = res.data;
        $scope.affectedMembers.push($scope.friend);
        messageListing();
      });
    }

    init();

    $scope.logout = function() {
      $cookies.remove('auth_user');
      $location.path('/');
    }

    $scope.message = function() {
      $scope.newMessage.sender = $scope.user.id;
      $scope.newMessage.reciever = $scope.friend.id;
      Api.create('message', $scope.newMessage, function() {
        $scope.newMessage.message = "";
        messageListing(function() {
          $("#message-text").focus();
        });
      });
    }
  }
])
'use strict'

# syntactic sugar
window.$ = angular.element

# glue modules
sciApp = angular.module('sciApp', ['ngRoute', 'ngAnimate', 'sciCtrl', 'sciService', 'sciFilter'])
sciApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/'
		templateUrl: '/static/partial/home.html'
		controller: 'homeCtrl'
	).when('/list'
		templateUrl: '/static/partial/list.html'
		controller: 'listCtrl'
	).otherwise(
		redirectTo: '/'
	)
])

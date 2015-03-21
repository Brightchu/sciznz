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
	).when('/device/:deviceID'
		templateUrl: '/static/partial/device.html',
		controller: 'deviceCtrl'
	).otherwise(
		redirectTo: '/'
	)
])

sciApp.config(['$compileProvider', ($compileProvider)->
	$compileProvider.debugInfoEnabled(false)
])

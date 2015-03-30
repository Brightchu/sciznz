'use strict'

# syntactic sugar
window.$ = angular.element

# glue modules
sciApp = angular.module('sciApp', ['ngRoute', 'ngAnimate', 'pascalprecht.translate', 'sciCtrl', 'sciService', 'sciFilter'])
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

sciApp.config(['$translateProvider', ($translateProvider)->
	$translateProvider.translations 'zh',
		flow: '流程'
		user: '用户'
		login: '登录'

	$translateProvider.preferredLanguage('zh')

])

'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

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
		login: '登录'
		all: '全部'

	$translateProvider.preferredLanguage('zh')

])

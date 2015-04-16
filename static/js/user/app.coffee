'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
userApp = angular.module('userApp', ['ngRoute', 'ngAnimate', 'userCtrl', 'userService', 'userFilter'])
userApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/order-active'
		templateUrl: '/static/partial/user/order-active.html'
		controller: 'orderActiveCtrl'
	).when('/order-done'
		templateUrl: '/static/partial/user/order-done.html'
		controller: 'orderDoneCtrl'
	).when('/personal-info'
		templateUrl: '/static/partial/user/personal-info.html'
		controller: 'personalInfoCtrl'
	).otherwise(
		redirectTo: '/order-active'
	)
])

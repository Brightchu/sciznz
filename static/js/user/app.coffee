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
	$routeProvider.when('/unread-message'
		templateUrl: '/static/partial/user/personal-info.html'
		controller: 'personalInfoCtrl'
	).when('/personal-info'
		templateUrl: '/static/partial/user/personal-info.html'
		controller: 'personalInfoCtrl'
	).when('/booking-info'
		templateUrl: '/static/partial/user/booking-info.html'
		controller: 'bookingInfoCtrl'
	).otherwise(
		redirectTo: '/unread-message'
	)
])

'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
ucenterApp = angular.module('ucenterApp', ['ngRoute', 'ngAnimate', 'ucenterCtrl', 'ucenterService', 'ucenterFilter'])
ucenterApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/personal-info'
		templateUrl: '/static/partial/ucenter/personal-info.html'
		controller: 'personalInfoCtrl'
	).when('/booking-info'
		templateUrl: '/static/partial/ucenter/booking-info.html'
		controller: 'bookingInfoCtrl'
	).otherwise(
		redirectTo: '/personal-info'
	)
])

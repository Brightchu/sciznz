'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
providerApp = angular.module('providerApp', ['ngRoute', 'ngAnimate', 'providerCtrl', 'providerService', 'providerFilter'])
providerApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/message-new'
		templateUrl: '/static/partial/provider/message-new.html'
		controller: 'messageNewCtrl'
	).when('/device-timetable'
		templateUrl: '/static/partial/provider/device-timetable.html'
		controller: 'deviceTimetableCtrl'
	).otherwise(
		redirectTo: '/message-new'
	)
])

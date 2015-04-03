'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
supplyApp = angular.module('supplyApp', ['ngRoute', 'ngAnimate', 'supplyCtrl', 'supplyService', 'supplyFilter'])
supplyApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/message-new'
		templateUrl: '/static/partial/supply/message-new.html'
		controller: 'messageNewCtrl'
	).when('/device-timetable'
		templateUrl: '/static/partial/supply/device-timetable.html'
		controller: 'deviceTimetableCtrl'
	).otherwise(
		redirectTo: '/message-new'
	)
])

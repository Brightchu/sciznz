'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
groupApp = angular.module('groupApp', ['ngRoute', 'ngAnimate', 'groupCtrl', 'groupService', 'groupFilter'])
groupApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/personal-info'
		templateUrl: '/static/partial/group/personal-info.html'
		controller: 'personalInfoCtrl'
	).when('/bill-info'
		templateUrl: '/static/partial/group/bill-info.html'
		controller: 'billInfoCtrl'
	).otherwise(
		redirectTo: '/personal-info'
	)
])

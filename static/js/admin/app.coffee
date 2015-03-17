'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
adminApp = angular.module('adminApp', ['ngRoute', 'ngAnimate', 'adminCtrl', 'adminService'])
adminApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/data-overview'
		templateUrl: '/static/partial/admin/generic-blank.html'
		controller: 'dataOverview'
	).when('/data-visitor'
		templateUrl: '/static/partial/admin/generic-blank.html'
		controller: 'dataVisitor'
	).when('/data-booking'
		templateUrl: '/static/partial/admin/generic-blank.html'
		controller: 'dataBooking'
	).when('/data-payment'
		templateUrl: '/static/partial/admin/generic-blank.html'
		controller: 'dataPayment'
	).when('/front-hierarchy'
		templateUrl: '/static/partial/admin/generic-json.html'
		controller: 'frontHierarchy'
	).when('/front-category'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'frontCategory'
	).when('/front-model'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'frontModel'
	).when('/front-device'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'frontDevice'
	).when('/front-cache'
		templateUrl: '/static/partial/admin/front-cache.html'
		controller: 'frontCache'
	).when('/cache-admin'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'cacheAdmin'
	).when('/institute-admin'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'instituteAdmin'
	).when('/people-user'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'peopleUser'
	).when('/people-staff'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'peopleStaff'
	).when('/people-admin'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'peopleAdmin'
	).when('/booking-admin'
		templateUrl: '/static/partial/admin/generic-blank.html'
		controller: 'bookingAdmin'
	).otherwise(
		redirectTo: '/data-overview'
	)
])

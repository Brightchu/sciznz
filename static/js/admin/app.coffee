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
	).when('/front-admin'
		templateUrl: '/static/partial/admin/generic-json.html'
		controller: 'frontAdmin'
	).when('/category-admin'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'categoryAdmin'
	).when('/category-field'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'categoryField'
	).when('/category-keyword'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'categoryKeyword'
	).when('/model-admin'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'modelAdmin'
	).when('/model-field'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'modelField'
	).when('/model-keyword'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'modelKeyword'
	).when('/device-admin'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'deviceAdmin'
	).when('/device-field'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'deviceField'
	).when('/device-keyword'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'deviceKeyword'
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

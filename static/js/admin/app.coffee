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
		templateUrl: '/static/partial/admin/data-overview.html'
	).when('/data-visitor'
		templateUrl: '/static/partial/admin/data-visitor.html'
	).when('/data-booking'
		templateUrl: '/static/partial/admin/data-booking.html'
	).when('/data-payment'
		templateUrl: '/static/partial/admin/data-payment.html'
	).when('/front-admin'
		templateUrl: '/static/partial/admin/front-admin.html'
	).when('/class-admin'
		templateUrl: '/static/partial/admin/class-admin.html'
	).when('/class-arg'
		templateUrl: '/static/partial/admin/class-arg.html'
	).when('/class-keyword'
		templateUrl: '/static/partial/admin/class-keyword.html'
	).when('/model-admin'
		templateUrl: '/static/partial/admin/model-admin.html'
	).when('/model-arg'
		templateUrl: '/static/partial/admin/model-arg.html'
	).when('/model-keyword'
		templateUrl: '/static/partial/admin/model-keyword.html'
	).when('/device-admin'
		templateUrl: '/static/partial/admin/device-admin.html'
	).when('/device-arg'
		templateUrl: '/static/partial/admin/device-arg.html'
	).when('/device-keyword'
		templateUrl: '/static/partial/admin/device-keyword.html'
	).when('/org-admin'
		templateUrl: '/static/partial/admin/org-admin.html'
	).when('/people-user'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'peopleUserCtrl'
	).when('/people-staff'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'peopleStaffCtrl'
	).when('/people-admin'
		templateUrl: '/static/partial/admin/generic-table.html'
		controller: 'peopleAdminCtrl'
	).when('/booking-admin'
		templateUrl: '/static/partial/admin/booking-admin.html'
	).otherwise(
		redirectTo: '/data-overview'
	)
])

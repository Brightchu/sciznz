'use strict'

# syntactic sugar
angular.element.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	this[0].dispatchEvent(clickEvent)

window.$ = angular.element

# glue modules
supervisorApp = angular.module('supervisorApp', ['ngRoute', 'ngAnimate', 'supervisorCtrl', 'supervisorService'])
supervisorApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/data-overview'
		templateUrl: '/static/partial/supervisor/data-overview.html'
	).when('/data-visitor'
		templateUrl: '/static/partial/supervisor/data-visitor.html'
	).when('/data-booking'
		templateUrl: '/static/partial/supervisor/data-booking.html'
	).when('/data-payment'
		templateUrl: '/static/partial/supervisor/data-payment.html'
	).when('/front-admin'
		templateUrl: '/static/partial/supervisor/front-admin.html'
	).when('/class-admin'
		templateUrl: '/static/partial/supervisor/class-admin.html'
	).when('/class-arg'
		templateUrl: '/static/partial/supervisor/class-arg.html'
	).when('/class-keyword'
		templateUrl: '/static/partial/supervisor/class-keyword.html'
	).when('/model-admin'
		templateUrl: '/static/partial/supervisor/model-admin.html'
	).when('/model-arg'
		templateUrl: '/static/partial/supervisor/model-arg.html'
	).when('/model-keyword'
		templateUrl: '/static/partial/supervisor/model-keyword.html'
	).when('/device-admin'
		templateUrl: '/static/partial/supervisor/device-admin.html'
	).when('/device-arg'
		templateUrl: '/static/partial/supervisor/device-arg.html'
	).when('/device-keyword'
		templateUrl: '/static/partial/supervisor/device-keyword.html'
	).when('/org-admin'
		templateUrl: '/static/partial/supervisor/org-admin.html'
	).when('/people-user'
		templateUrl: '/static/partial/supervisor/people-user.html'
	).when('/people-operator'
		templateUrl: '/static/partial/supervisor/people-operator.html'
		controller: 'peopleOperatorCtrl'
	).when('/people-admin'
		templateUrl: '/static/partial/supervisor/people-admin.html'
		controller: 'peopleAdminCtrl'
	).when('/booking-admin'
		templateUrl: '/static/partial/supervisor/booking-admin.html'
	).otherwise(
		redirectTo: '/data-overview'
	)
])

'use strict'

supervisorApp = angular.module('supervisorApp', [
	'ngRoute',
	'ngAnimate',
	'supervisorCtrl'
])

supervisorApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.
	when('/', {
		templateUrl: '/static/partial/supervisor/overview.html',
		controller: 'overViewCtrl'
	}).
	when('/visitor', {
		templateUrl: '/static/partial/supervisor/visitor.html'
	}).
	when('/booking', {
		templateUrl: '/static/partial/supervisor/booking.html'
	}).
	when('/pay', {
		templateUrl: '/static/partial/supervisor/pay.html'
	}).
	when('/icon', {
		templateUrl: '/static/partial/supervisor/icon.html'
	}).
	when('/content', {
		templateUrl: '/static/partial/supervisor/content.html'
	}).
	when('/category', {
		templateUrl: '/static/partial/supervisor/category.html'
	}).
	when('/keyword', {
		templateUrl: '/static/partial/supervisor/keyword.html'
	}).
	when('/institute', {
		templateUrl: '/static/partial/supervisor/institute.html'
	}).
	when('/verify', {
		templateUrl: '/static/partial/supervisor/verify.html'
	}).
	when('/operator', {
		templateUrl: '/static/partial/supervisor/operator.html'
	}).
	when('/instrument', {
		templateUrl: '/static/partial/supervisor/instrument.html'
	}).
	when('/permit', {
		templateUrl: '/static/partial/supervisor/permit.html'
	}).
	when('/user', {
		templateUrl: '/static/partial/supervisor/user.html'
	}).
	when('/level', {
		templateUrl: '/static/partial/supervisor/level.html'
	}).
	when('/order', {
		templateUrl: '/static/partial/supervisor/order.html'
	}).
	when('/status', {
		templateUrl: '/static/partial/supervisor/status.html'
	}).
	otherwise({
		redirectTo: '/'
	});
])
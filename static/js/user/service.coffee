'use strict'

userService = angular.module('userService', ['ngResource'])
userService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

userService.factory('User', ['$resource', ($resource)->
	$resource '/user/', {},
		payMethod:
			url: '/user/payMethod'
			isArray: true
])

userService.factory('Order', ['$resource', ($resource)->
	$resource '/order/', {},
		userActive:
			url: '/order/userActive'
			isArray: true

		userDone:
			url: '/order/userDone'
			isArray: true

		cancel:
			url: '/order/cancel'
			method: 'POST'

		budget:
			url: '/order/budget'
			method: 'POST'

		fill:
			url: '/order/fill'
			method: 'POST'
])


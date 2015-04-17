'use strict'

userService = angular.module('userService', ['ngResource'])
userService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

userService.factory('User', ['$resource', ($resource)->
	$resource '/user/', {},
		payMethod:
			url: 'payMethod'
			isArray: true

		info:
			url: 'info'

		updateInfo:
			url: 'updateInfo'
			method: 'POST'

		updatePassword:
			url: 'updatePassword'
			method: 'POST'

])

userService.factory('Order', ['$resource', ($resource)->
	$resource '/order/', {},
		userActive:
			url: 'userActive'
			isArray: true

		userDone:
			url: 'userDone'
			isArray: true

		cancel:
			url: 'cancel'
			method: 'POST'

		budget:
			url: 'budget'
			method: 'POST'

		fill:
			url: 'fill'
			method: 'POST'
])

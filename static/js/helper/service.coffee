'use strict'

helperService = angular.module('helperService', ['ngResource'])
helperService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

helperService.factory('Order', ['$resource', ($resource)->
	$resource '/order/', {},
		helperActive:
			url: '/order/helperActive'
			isArray: true

		helperDone:
			url: '/order/helperDone'
			isArray: true

		confirm:
			url: '/order/confirm'
			method: 'POST'

		begin:
			url: '/order/begin'
			method: 'POST'

		end:
			url: '/order/end'
			method: 'POST'

		cancel:
			url: '/order/cancel'
			method: 'POST'

		detail:
			url: '/order/budget'
			method: 'POST'
])

helperService.factory('Helper', ['$resource', ($resource)->
	$resource '/helper/', {},
		info:
			url: '/helper/info'

		updateInfo:
			url: '/helper/updateInfo'
			method: 'POST'

		updatePassword:
			url: '/helper/updatePassword'
			method: 'POST'

])

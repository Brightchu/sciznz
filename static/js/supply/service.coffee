'use strict'

supplyService = angular.module('supplyService', ['ngResource'])
supplyService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

supplyService.factory('Order', ['$resource', ($resource)->
	$resource '/order/', {},
		supplyActive:
			url: '/order/supplyActive'
			isArray: true

		supplyDone:
			url: '/order/supplyDone'
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

supplyService.factory('Supply', ['$resource', ($resource)->
	$resource '/supply/', {},
		info:
			url: '/supply/info'

		updateInfo:
			url: '/supply/updateInfo'
			method: 'POST'

		updatePassword:
			url: '/supply/updatePassword'
			method: 'POST'

])

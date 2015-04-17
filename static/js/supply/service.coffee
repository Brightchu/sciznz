'use strict'

supplyService = angular.module('supplyService', ['ngResource'])
supplyService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

supplyService.factory('Order', ['$resource', ($resource)->
	$resource '/order/', {},
		supplyActive:
			url: 'supplyActive'
			isArray: true

		supplyDone:
			url: 'supplyDone'
			isArray: true

		confirm:
			url: 'confirm'
			method: 'POST'

		begin:
			url: 'begin'
			method: 'POST'

		end:
			url: 'end'
			method: 'POST'

		cancel:
			url: 'cancel'
			method: 'POST'

		detail:
			url: 'budget'
			method: 'POST'
])

supplyService.factory('Supply', ['$resource', ($resource)->
	$resource '/supply/', {},
		info:
			url: 'info'

		updateInfo:
			url: 'updateInfo'
			method: 'POST'

		updatePassword:
			url: 'updatePassword'
			method: 'POST'

])

'use strict'

supplyService = angular.module('supplyService', ['ngResource'])
supplyService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

supplyService.factory('Order', ['$resource', ($resource)->
	$resource('/supply/order')
])

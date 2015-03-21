'use strict'

providerService = angular.module('providerService', ['ngResource'])
providerService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

providerService.factory('Order', ['$resource', ($resource)->
	$resource('/provider/order')
])

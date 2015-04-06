'use strict'

groupService = angular.module('groupService', ['ngResource'])
groupService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

groupService.factory('Info', ['$resource', ($resource)->
	$resource('/group/info')
])

groupService.factory('Order', ['$resource', ($resource)->
	$resource('/group/order')
])

groupService.factory('Member', ['$resource', ($resource)->
	$resource('/group/member')
])

groupService.factory('Bill', ['$resource', ($resource)->
	$resource('/group/bill')
])

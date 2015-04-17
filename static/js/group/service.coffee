'use strict'

groupService = angular.module('groupService', ['ngResource'])
groupService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

groupService.factory('Group', ['$resource', ($resource)->
	$resource '/group/', {},
		info:
			url: 'info'

		updateInfo:
			url: 'updateInfo'
			method: 'POST'

		updatePassword:
			url: 'updatePassword'
			method: 'POST'

])


groupService.factory('Member', ['$resource', ($resource)->
	$resource('/group/member')
])

groupService.factory('Bill', ['$resource', ($resource)->
	$resource('/group/bill')
])

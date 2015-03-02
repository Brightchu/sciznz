'use strict'

supervisorService = angular.module('supervisorService', ['ngResource'])
supervisorService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

supervisorService.factory('User', ['$resource', ($resource)->
	$resource('/supervisor/peopleUser/')
])

supervisorService.factory('Staff', ['$resource', ($resource)->
	$resource('/supervisor/peopleOperator/')
])

supervisorService.factory('Admin', ['$resource', ($resource)->
	$resource('/supervisor/peopleSupervisor/')
])

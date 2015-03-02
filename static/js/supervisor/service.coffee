'use strict'

supervisorService = angular.module('supervisorService', ['ngResource'])

supervisorService.factory('User', ['$resource', ($resource)->
	$resource('/supervisor/peopleUser/', {}, {
		update: {
			method: 'PUT'
		}
	})
])

supervisorService.factory('Staff', ['$resource', ($resource)->
	$resource('/supervisor/peopleOperator/', {}, {
		update: {
			method: 'PUT'
		}
	})
])

supervisorService.factory('Admin', ['$resource', ($resource)->
	$resource('/supervisor/peopleSupervisor/', {}, {
		update: {
			method: 'PUT'
		}
	})
])

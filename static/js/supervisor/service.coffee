'use strict'

supervisorService = angular.module('supervisorService', ['ngResource'])
supervisorService.factory('Admin', ['$resource', ($resource)->
	$resource('/supervisor/admin/', {}, {
		update: {
			method: 'PUT'
		}
	})
])

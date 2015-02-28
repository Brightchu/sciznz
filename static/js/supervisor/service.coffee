'use strict'

supervisorService = angular.module('supervisorService', ['ngResource'])

supervisorService.factory('Admin', ($resource)->
	$resource('/supervisor/admin/', {}, {

	})
)

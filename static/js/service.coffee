'use strict'

sciService = angular.module('sciService', ['ngResource'])
sciService.factory('Login', ['$resource', ($resource)->
	$resource('/api/login')
])

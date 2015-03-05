'use strict'

sciService = angular.module('sciService', ['ngResource'])

sciService.factory('Query', ['$resource', ($resource)->
	$resource('/api/query')
])

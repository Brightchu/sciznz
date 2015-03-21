'use strict'

ucenterService = angular.module('ucenterService', ['ngResource'])
ucenterService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

ucenterService.factory('Info', ['$resource', ($resource)->
	$resource('/ucenter/info')
])


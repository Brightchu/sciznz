'use strict'

adminService = angular.module('adminService', ['ngResource'])
adminService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

adminService.factory('FrontCache', ['$resource', ($resource)->
	$resource('/admin/frontCache')
])

adminService.factory('FrontGroup', ['$resource', ($resource)->
	$resource('/admin/frontGroup')
])

adminService.factory('FrontCategory', ['$resource', ($resource)->
	$resource('/admin/frontCategory')
])

adminService.factory('FrontModel', ['$resource', ($resource)->
	$resource('/admin/frontModel')
])

adminService.factory('FrontDevice', ['$resource', ($resource)->
	$resource('/admin/frontDevice')
])

adminService.factory('Institute', ['$resource', ($resource)->
	$resource('/admin/instituteAdmin')
])

adminService.factory('User', ['$resource', ($resource)->
	$resource('/admin/peopleUser')
])

adminService.factory('Operator', ['$resource', ($resource)->
	$resource('/admin/peopleStaff')
])

adminService.factory('Supervisor', ['$resource', ($resource)->
	$resource('/admin/peopleAdmin')
])

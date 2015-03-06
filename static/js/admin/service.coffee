'use strict'

adminService = angular.module('adminService', ['ngResource'])
adminService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

adminService.factory('FrontGroup', ['$resource', ($resource)->
	$resource('/admin/frontGroup')
])

adminService.factory('Category', ['$resource', ($resource)->
	$resource('/admin/categoryAdmin')
])

adminService.factory('CategoryField', ['$resource', ($resource)->
	$resource('/admin/categoryField')
])

adminService.factory('CategoryKeyword', ['$resource', ($resource)->
	$resource('/admin/categoryKeyword')
])

adminService.factory('Model', ['$resource', ($resource)->
	$resource('/admin/modelAdmin')
])

adminService.factory('ModelField', ['$resource', ($resource)->
	$resource('/admin/modelField')
])

adminService.factory('ModelKeyword', ['$resource', ($resource)->
	$resource('/admin/modelKeyword')
])

adminService.factory('Device', ['$resource', ($resource)->
	$resource('/admin/deviceAdmin')
])

adminService.factory('DeviceField', ['$resource', ($resource)->
	$resource('/admin/deviceField')
])

adminService.factory('DeviceKeyword', ['$resource', ($resource)->
	$resource('/admin/deviceKeyword')
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

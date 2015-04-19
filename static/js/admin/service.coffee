'use strict'

adminService = angular.module('adminService', ['ngResource'])
adminService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

adminService.factory('FrontHierarchy', ['$resource', ($resource)->
	$resource('/admin/frontHierarchy')
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

adminService.factory('FrontCache', ['$resource', ($resource)->
	$resource('/admin/frontCache')
])

adminService.factory('CacheAdmin', ['$resource', ($resource)->
	$resource('/admin/cacheAdmin')
])

adminService.factory('User', ['$resource', ($resource)->
	$resource('/admin/peopleUser')
])

adminService.factory('Supply', ['$resource', ($resource)->
	$resource('/admin/peopleSupply')
])

adminService.factory('Group', ['$resource', ($resource)->
	$resource('/admin/peopleGroup')
])

adminService.factory('Helper', ['$resource', ($resource)->
	$resource('/admin/peopleHelper')
])

adminService.factory('Admin', ['$resource', ($resource)->
	$resource '/admin/peopleAdmin', {},
		info:
			url: '/admin/info'
])

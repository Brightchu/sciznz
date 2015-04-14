'use strict'

sciService = angular.module('sciService', ['ngResource'])
sciService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

sciService.factory 'data', ['$http', ($http)->
	data = JSON.parse(localStorage.getItem('data'))
	if not data
		data =
			hierarchy: {}
			device: {}
			index:
				contain: {}
				locale: []
				feature: {}
				category: {}

	promise = $http
		method: 'GET'
		url: '/cache'
		headers:
			'If-Modified-Since': localStorage.getItem('Last-Modified')
		responseType: 'json'

	promise.success (body, status, headers)->
		angular.copy(body, data)
		localStorage.setItem('data', JSON.stringify(body))
		localStorage.setItem('Last-Modified', headers('Last-Modified'))

	promise.error (body, status)->
		if status != 304
			console.warn('synchronize data failed')

	return data
]

sciService.factory('User', ['$resource', ($resource)->
	$resource '/user', {},
		auth:
			url: '/user/auth'
			method: 'POST'
		register:
			url: '/user/register'
			method: 'POST'
])

sciService.factory('Device', ['$resource', ($resource)->
	$resource '/device/', {},
		resource:
			url: '/device/resource/:deviceID/:date'
			method: 'GET'

])

sciService.factory('Order', ['$resource', ($resource)->
	$resource '/order/', {},
		create:
			url: '/order/create'
			method: 'POST'

])

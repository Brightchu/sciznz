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
			hierarchy: []
			device: []
			contain: []

	promise = $http
		method: 'GET'
		url: '/api/query'
		headers:
			'If-Modified-Since': localStorage.getItem('Last-Modified')
		responseType: 'json'

	promise.success (body, status, headers)->
		if not data.hierarchy.length
			for key, value of body
				if angular.isArray(value)
					Array.prototype.push.apply(data[key], value)
				else
					for k, v of value
						data[key][k] = v

		localStorage.setItem('data', JSON.stringify(body))
		localStorage.setItem('Last-Modified', headers('Last-Modified'))

	promise.error (body, status)->
		if status != 304
			console.warn('synchronize data failed')

	return data
]

sciService.factory('User', ['$resource', ($resource)->
	$resource('/api/user')
])

sciService.factory('Order', ['$resource', ($resource)->
	$resource('/api/order')
])

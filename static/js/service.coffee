'use strict'

sciService = angular.module('sciService', ['ngResource'])
sciService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

sciService.factory 'data', ['$http', ($http)->
	data = JSON.parse(localStorage.getItem('data')) || {}
	never = !Boolean(data)

	promise = $http
		method: 'GET'
		url: '/api/query'
		headers:
			'If-Modified-Since': localStorage.getItem('Last-Modified')
		responseType: 'json'

	promise.success (body, status, headers)->
		data = body
		localStorage.setItem('data', JSON.stringify(body))
		localStorage.setItem('Last-Modified', headers('Last-Modified'))
		location.reload() if never

	promise.error (body, status)->
		if status != 304
			alert('XMLHttpRequest Error!')

	return data
]

sciService.factory('User', ['$resource', ($resource)->
	$resource('/api/user')
])

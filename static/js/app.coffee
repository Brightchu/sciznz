'use strict'

_data = JSON.parse(localStorage.getItem('data'))

req = new XMLHttpRequest()
req.open('GET', '/api/query')
req.overrideMimeType('application/json')
req.onerror = ->
	alert('XMLHttpRequest Error!')
req.onload = ->
	if this.status == 200
		_data = JSON.parse(this.responseText)
		localStorage.setItem('data', this.responseText)
		localStorage.setItem('Last-Modified', this.getResponseHeader('Last-Modified'))

req.setRequestHeader('If-Modified-Since', localStorage.getItem('Last-Modified'))
req.send()

# syntactic sugar
window.$ = angular.element

# glue modules
sciApp = angular.module('sciApp', ['ngRoute', 'ngAnimate', 'ui.utils', 'sciCtrl', 'sciService', 'sciFilter'])
sciApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/'
		templateUrl: '/static/partial/home.html'
		controller: 'homeCtrl'
	).when('/list'
		templateUrl: '/static/partial/list.html'
		controller: 'listCtrl'
	).otherwise(
		redirectTo: '/'
	)
])

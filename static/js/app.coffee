'use strict'

ever = Boolean(localStorage.length)
req = new XMLHttpRequest()
req.open('GET', '/api/query')
req.overrideMimeType('application/json')
req.onerror = ->
	alert('XMLHttpRequest Error!')
req.onload = ->
	if this.status == 200
		localStorage.setItem('Last-Modified', this.getResponseHeader('Last-Modified'))
		for key, value of JSON.parse(this.responseText)
			localStorage.setItem(key, JSON.stringify(value))
		location.reload() if not ever
req.setRequestHeader('If-Modified-Since', localStorage.getItem('Last-Modified')) if ever
req.send()

# syntactic sugar
window.$ = angular.element

# glue modules
sciApp = angular.module('sciApp', ['ngRoute', 'ngAnimate', 'ui.utils', 'sciCtrl', 'sciService'])
sciApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/'
		templateUrl: '/static/partial/home.html'
		controller: 'homeCtrl'
	).otherwise(
		redirectTo: '/'
	)
])

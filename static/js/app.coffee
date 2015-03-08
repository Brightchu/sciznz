'use strict'

fresh = !Boolean(localStorage.length)
req = new XMLHttpRequest()
req.open('GET', '/api/query')
req.overrideMimeType('application/json')
req.onerror = ->
	alert('XMLHttpRequest Error!')
req.onload = ->
	if this.status == 200
		for key, value of JSON.parse(this.responseText)
			localStorage.setItem(key, JSON.stringify(value))
		localStorage.setItem('Last-Modified', this.getResponseHeader('Last-Modified'))
		location.reload() if fresh
req.setRequestHeader('If-Modified-Since', localStorage.getItem('Last-Modified')) if not fresh
req.send()

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
sciApp = angular.module('sciApp', ['ngRoute', 'ngAnimate', 'ui.utils', 'sciCtrl', 'sciService'])
sciApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/'
		templateUrl: '/static/partial/home.html'
		controller: 'homeCtrl'
	).when('/category/:categoryName'
		templateUrl: '/static/partial/category.html',
		controller: 'categoryCtrl'
	).otherwise(
		redirectTo: '/'
	)
])

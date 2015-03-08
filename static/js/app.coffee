'use strict'

req = new XMLHttpRequest()
req.open('GET', '/api/query')
req.onerror = ->
	alert('XMLHttpRequest Error!')
req.onload = ->
	data = JSON.parse(this.responseText)
	first = !Boolean(localStorage.length)
	for key, value of data
		localStorage.setItem(key, JSON.stringify(value))
	location.reload() if first
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

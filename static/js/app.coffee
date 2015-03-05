'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
sciApp = angular.module('sciApp', ['ngRoute', 'ngAnimate', 'ui.utils', 'sciCtrl', 'sciService'])

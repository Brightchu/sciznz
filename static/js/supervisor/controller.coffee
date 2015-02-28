'use strict'

supervisorCtrl = angular.module('supervisorCtrl', ['ui.bootstrap'])

supervisorCtrl.controller 'AccordionCtrl', ($scope)->
	$scope.isFirstOpen = true

	angular.element(document).ready ->
		angular.element(document.querySelector('.panel-heading')).addClass('open')
		angular.element(document.querySelector('.panel-group p')).addClass('active')

		heading = angular.element(document.querySelectorAll('.panel-heading'))
		heading.on 'click', ->
			heading.removeClass('open')
			angular.element(this).addClass('open')

		entry = angular.element(document.querySelectorAll('.panel-group p'))
		entry.on 'click', ->
			entry.removeClass('active')
			angular.element(this).addClass('active')

supervisorCtrl.controller 'overViewCtrl', ($scope)->
	
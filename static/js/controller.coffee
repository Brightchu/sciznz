'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap'])
sciCtrl.controller 'homeCtrl', ['$scope', ($scope)->
	$(document.querySelector('#line')).css('background-color', 'rgb(237, 40, 43)')
	$scope.group = JSON.parse(localStorage.getItem('group'))
	$scope.currentGroup = $scope.group[0].child
]

sciCtrl.controller 'categoryCtrl', ['$scope', '$routeParams', ($scope, $routeParams)->
	$(document.querySelector('#line')).css('background-color', 'rgb(249, 188, 0)')
	$scope.grouplist = JSON.parse(localStorage.getItem('grouplist'))
	if not $routeParams.categoryName?
		$routeParams.categoryName = $scope.grouplist[0].name

	$(document).ready ->
		heading = $(document.querySelectorAll('.panel-heading'))
		heading.on 'click', ->
			heading.removeClass('open')
			$(this).addClass('open')

		entry = $(document.querySelectorAll('.panel-group p'))
		entry.on 'click', ->
			entry.removeClass('active')
			$(this).addClass('active')

		link = $(document.querySelector("[href='#/category/#{$routeParams.categoryName}']"))
		link.parent().click()
		$($(link.parent().parent().parent().parent().children()[0]).children()[0]).children().click()

	categoryMap = JSON.parse(localStorage.getItem('categoryMap'))
	thisCategory = JSON.parse(localStorage.getItem('category')).filter (value)->
		return value.name == $routeParams.categoryName

	$scope.categoryName = $routeParams.categoryName
	thisID = thisCategory[0].ID

	fieldMap = {}
	for field in thisCategory[0].field
		fieldMap[field] =
			name: field
			checked: true

	$scope.field = fieldMap

	modelList = JSON.parse(localStorage.getItem('model')).filter (value)->
		return value.categoryID == thisID

	$scope.modelList = modelList
]

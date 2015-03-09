'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap'])
sciCtrl.controller 'navCtrl', ['$scope', '$modal', ($scope, $modal)->
	storageName = localStorage.getItem('name')
	if storageName
		$scope.name = storageName
	else
		$scope.name = '登录 / 注册'

	$scope.open = ->
		modalInstance = $modal.open
			templateUrl: '/static/partial/login.html'
			controller: 'loginCtrl'
			size: 'sm'
			windowClass: 'login'

		modalInstance.result.then (res)->
			name = ''
			for k, v of res
				if typeof(v) == 'string'
					name += v
			localStorage.setItem('name', name)
			$scope.name = name
]

sciCtrl.controller 'loginCtrl', ['$scope', '$modalInstance', 'Login', ($scope, $modalInstance, Login)->
	$scope.signin = ->
		form = 
			username: $scope.username
			password: $scope.password
		pro = Login.save(form).$promise
		pro.catch (res)->
			$scope.error = true
		pro.then (res)->
			$modalInstance.close(res)
]

sciCtrl.controller 'homeCtrl', ['$scope', ($scope)->
	$(document.querySelector('#line')).css('background-color', 'rgb(237, 40, 43)')
	$scope.group = JSON.parse(localStorage.getItem('group'))
	$scope.currentGroup = $scope.group[0].child
]

sciCtrl.controller 'categoryCtrl', ['$scope', '$routeParams', ($scope, $routeParams)->
	$(document.querySelector('#line')).css('background-color', 'rgb(249, 188, 0)')
	$scope.grouplist = JSON.parse(localStorage.getItem('grouplist'))
	if not $routeParams.categoryName?
		$routeParams.categoryName = $scope.grouplist[0].child[0]

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

	$scope.jump = (model)->
		location.hash = "/model/#{model.vendor}/#{model.name}"
]

sciCtrl.controller 'modelCtrl', ['$scope', '$routeParams', ($scope, $routeParams)->
	$(document.querySelector('#line')).css('background-color', 'rgb(0, 169, 88)')
	if not $routeParams.vendor?
		$routeParams.vendor = JSON.parse(localStorage.getItem('model'))[0].vendor
	if not $routeParams.name?
		$routeParams.name = JSON.parse(localStorage.getItem('model'))[0].name
	thisModel = JSON.parse(localStorage.getItem('model')).filter (value)->
		return value.vendor == $routeParams.vendor and value.name == $routeParams.name
	thisID = thisModel[0].ID
	thisCategoryID = thisModel[0].categoryID
	thisCategory = JSON.parse(localStorage.getItem('category')).filter (value)->
		return value.ID == thisCategoryID
	thisCategoryModel = JSON.parse(localStorage.getItem('model')).filter (value)->
		return value.categoryID == thisCategoryID
	deviceList = JSON.parse(localStorage.getItem('device')).filter (value)->
		return value.modelID == thisID
	thisCategoryName = thisCategory[0].name

	$scope.modelName = "#{$routeParams.vendor} - #{$routeParams.name}"
	$scope.category = thisCategoryName
	$scope.modelList = thisCategoryModel
	$scope.isFirstOpen = true
	$scope.deviceList = deviceList
]

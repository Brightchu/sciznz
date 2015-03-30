'use strict'

sciCtrl = angular.module('sciCtrl', ['ngCookies', 'ui.bootstrap', 'ui.utils'])

sciCtrl.controller 'navCtrl', ['$scope', '$modal', '$cookies', ($scope, $modal, $cookies)->
	$scope.name = $cookies.name || 'login'

	$scope.open = ->
		if $cookies.name?
			location.href = '/ucenter'
		else
			login()

	login = ->
		modalInstance = $modal.open
			templateUrl: '/static/partial/login.html'
			controller: 'loginCtrl'
			size: 'sm'
			windowClass: 'login'
			backdropClass: 'loginBack'

		modalInstance.result.then (name)->
			$cookies.name = name
			$scope.name = name
]

sciCtrl.controller 'loginCtrl', ['$scope', '$modalInstance', 'User', '$timeout', ($scope, $modalInstance, User, $timeout)->
	$scope.signin = ->
		form =
			username: $scope.username
			password: $scope.password

		result = User.update(form).$promise
		result.catch ->
			$scope.error = true
		result.then ->
			cookiePair = {}
			for cookie in document.cookie.split('; ')
				[k, v] = cookie.split('=')
				cookiePair[k] = v
			$modalInstance.close(decodeURIComponent(cookiePair['name']))

	$scope.signup = ->
		form =
			username: $scope.username
			password: $scope.password

		result = User.save(form).$promise
		result.catch ->
			$scope.warning = true
		result.then ->
			$scope.success = true
			cookiePair = {}
			for cookie in document.cookie.split('; ')
				[k, v] = cookie.split('=')
				cookiePair[k] = v

			$timeout ->
				$modalInstance.close(decodeURIComponent(cookiePair['name']))
			, 1000
]

sciCtrl.controller 'homeCtrl', ['$scope', '$rootScope', 'data', ($scope, $rootScope, data)->
	$scope.groupList = data.hierarchy

	$scope.onEntry = ->
		if this.group?
			$rootScope.groupSelected = this.group.name
		else
			$rootScope.groupSelected = '全部类别'
		location.hash = '#list'

	$(document).ready ->
		cubes = document.querySelectorAll(".cube-perspective .cube")
		Array.prototype.forEach.call cubes, (el, i)->
			setTimeout ->
				el.className += " hover"
			, 1000 + i * 400
]

sciCtrl.controller 'listCtrl', ['$scope', '$rootScope', 'data', ($scope, $rootScope, data)->
	$scope.groupList = data.hierarchy
	$scope.deviceList = data.device
	$scope.addressList = data.address
	$scope.isCollapsed = true
	$scope.showMoreSubGroup = false
	$scope.showMoreCategory = false
	$rootScope.field = {}

	$scope.filterModel =
		group: $rootScope.groupSelected
		subgroup: '全部子类'
		address: '全部地点'
		category: '全部款式'
		field: {}

	$scope.moreSubGroup = []
	$scope.moreCateogory = []
]

sciCtrl.controller 'deviceCtrl', ['$scope', '$routeParams', 'data', 'Order', '$filter', ($scope, $routeParams, data, Order, $filter)->
	thisDeviceID = parseInt($routeParams.deviceID)
	thisDevice = null
	for device in data.device
		if device.ID == thisDeviceID
			thisDevice = device
			break
	$scope.device = thisDevice

	minDate = new Date()
	minDate.setDate(minDate.getDate() + 1)
	maxDate = new Date()
	maxDate.setDate(maxDate.getDate() + 30)

	$scope.minDate = minDate
	$scope.maxDate = maxDate
	$scope.date = minDate
	$scope.book = ->
		d = $scope.date
		payload =
			deviceID: thisDeviceID
			useDate: $filter('date')($scope.date, 'yyyy-MM-dd')
		Order.save(payload).$promise.then ->
			alert('预约成功')

	updateRemain = (useDate)->
		payload =
			deviceID: thisDeviceID
			useDate: $filter('date')(useDate, 'yyyy-MM-dd')
		$scope.stat = Order.get(payload)

	updateRemain(minDate)

	$scope.$watch 'date', (name, oldValue, newValue)->
		updateRemain(newValue)
		return newValue
]

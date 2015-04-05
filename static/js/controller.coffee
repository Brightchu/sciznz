'use strict'

sciCtrl = angular.module('sciCtrl', ['ngCookies', 'ui.bootstrap', 'ui.utils', 'duScroll'])

sciCtrl.controller 'navCtrl', ['$scope', '$modal', '$cookies', '$document', ($scope, $modal, $cookies, $document)->
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

	$scope.scrollTo = (selector)->
		$document.scrollToElementAnimated($(document.querySelector(selector)), 100);

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

sciCtrl.controller 'homeCtrl', ['$scope', '$rootScope', '$document', 'data', ($scope, $rootScope, $document, data)->
	$scope.groupList = data.hierarchy

	$scope.onEntry = ->
		if this.group?
			$rootScope.groupSelected = this.group.name
		else
			$rootScope.groupSelected = '全部类别'
		location.hash = '#list'

	$scope.scrollTo = (selector)->
		$document.scrollToElementAnimated($(document.querySelector(selector)), 100);

	$(document).ready ->
		cubes = document.querySelectorAll(".cube-perspective .cube")
		Array.prototype.forEach.call cubes, (element, index)->
			setTimeout ->
				$(element).addClass('hover')
			, 500 * index

		$(document.querySelector('div#comment img')).click()

]

sciCtrl.controller 'listCtrl', ['$scope', '$filter', 'data', ($scope, $filter, data)->
	$scope.data = data

	$scope.isCollapsed = true
	$scope.hideMoreFeature = true
	$scope.hideMoreCategory = true

	$scope.filterModel =
		domain: $filter('translate')('unlimit')
		feature: $filter('translate')('unlimit')
		category: $filter('translate')('unlimit')
		address: $filter('translate')('unlimit')
		field: {}
]

sciCtrl.controller 'deviceCtrl', ['$scope', '$routeParams', 'data', 'Order', '$filter', ($scope, $routeParams, data, Order, $filter)->
	thisDevice = data.device[$routeParams.deviceID]
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
			deviceID: thisDevice.ID
			useDate: $filter('date')($scope.date, 'yyyy-MM-dd')
		Order.save(payload).$promise.then ->
			alert('预约成功')

	updateRemain = (useDate)->
		payload =
			deviceID: thisDevice.ID
			useDate: $filter('date')(useDate, 'yyyy-MM-dd')
		$scope.stat = Order.get(payload)

	updateRemain(minDate)

	$scope.$watch 'date', (name, oldValue, newValue)->
		updateRemain(newValue)
		return newValue
]

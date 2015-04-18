'use strict'

sciCtrl = angular.module('sciCtrl', ['ngCookies', 'ui.bootstrap', 'ui.utils', 'duScroll'])

sciCtrl.controller 'navCtrl', ['$scope', '$modal', '$cookies', '$document', '$window', ($scope, $modal, $cookies, $document, $window)->
	$scope.name = $cookies.name || 'login'

	$scope.open = ->
		if $cookies.name?
			$window.location.href = '/user'
		else
			login()

	login = ->
		openLoginModel($modal, $scope)

	$scope.scrollTo = (selector)->
		if $window.location.hash == '#/list'
			$window.location.hash = '/'
		else
			$document.scrollToElementAnimated($(document.querySelector(selector)), 100);

]

openLoginModel = ($modal, $scope)->
	modalInstance = $modal.open
		templateUrl: '/static/partial/front/login.html'
		controller: 'loginCtrl'
		size: 'sm'
		windowClass: 'login'
		backdropClass: 'loginBack'

	modalInstance.result.then (name)->
		$scope.name = name

sciCtrl.controller 'loginCtrl', ['$scope', '$modalInstance', 'User', '$timeout', ($scope, $modalInstance, User, $timeout)->
	$scope.signup = ->
		form =
			email: $scope.email
			password: $scope.password

		result = User.register(form).$promise
		result.catch ->
			$scope.warning = true
		result.then (data)->
			$scope.success = true
			$timeout ->
				$modalInstance.close(data.name)
			, 1000

	$scope.signin = ->
		form =
			email: $scope.email
			password: $scope.password

		promise = User.auth(form).$promise
		promise.catch ->
			$scope.error = true
		promise.then (data)->
			$modalInstance.close(data.name)
]

sciCtrl.controller 'homeCtrl', ['$scope', '$document', 'data', ($scope, $document, data)->
	$scope.groupList = data.hierarchy
	$scope.scrollTo = (selector)->
		$document.scrollToElementAnimated($(document.querySelector(selector)), 100);

	$(document).ready ->
		setTimeout ->
			cubes = document.querySelectorAll(".cube-perspective .cube")
			Array.prototype.forEach.call cubes, (element, index)->
				setTimeout ->
					$(element).addClass('hover')
				, 500 * index
		, 3000

		$(document.querySelector('div#comment img')).click()

]

sciCtrl.controller 'listCtrl', ['$scope', '$rootScope', '$filter', 'data', ($scope, $rootScope, $filter, data)->
	$scope.data = data

	$scope.hideMoreFeature = true
	$scope.hideMoreCategory = true

	if not $rootScope.filterModel?
		$rootScope.filterModel =
			domain: $filter('translate')('unlimit')
			feature: $filter('translate')('unlimit')
			category: $filter('translate')('unlimit')
			locale: $filter('translate')('unlimit')
			field: {}

	$scope.filterModel.prototype = $rootScope.filterModel

	$scope.$watch 'filterModel.domain', (newValue, oldValue)->
		$scope.filterModel.feature = newValue
		$scope.filterModel.category = newValue

	$scope.$watch 'filterModel.feature', (newValue, oldValue)->
		$scope.filterModel.category = newValue
]

sciCtrl.controller 'deviceCtrl', ['$scope', '$routeParams', 'data', 'Device', '$filter', '$cookies', '$modal', ($scope, $routeParams, data, Device, $filter, $cookies, $modal)->
	$scope.device = data.device[$routeParams.deviceID]

	minDate = new Date()
	minDate.setDate(minDate.getDate() + 1)
	maxDate = new Date()
	maxDate.setDate(maxDate.getDate() + 30)

	$scope.minDate = minDate
	$scope.maxDate = maxDate
	$scope.date = minDate

	$scope.orderModel =
		method: $scope.device.schedule.method[0]

	$scope.book = ->
		if $cookies.name
			payload =
				category: $scope.device.category
				model: $scope.device.model
				deviceID: $scope.device.ID
				date: $filter('date')($scope.date, 'yyyy-MM-dd')
				method: $scope.orderModel.method
				resource: $scope.orderModel.resource

			if not payload.resource? and payload.method == 'RESOURCE'
				return alert('请选择预约项目')
			
			modalInstance = $modal.open
				templateUrl: '/static/partial/front/confirm.html'
				controller: 'confirmCtrl'
				resolve:
					payload: ->
						return payload

			modalInstance.result.then ->
				updateRemain($scope.date)

		else
			openLoginModel($modal, $scope)

	updateRemain = (date)->
		payload =
			deviceID: $scope.device.ID
			date: $filter('date')(date, 'yyyy-MM-dd')
		Device.resource(payload).$promise.then (body)->
			$scope.resource = body

	updateRemain(minDate)

	$scope.$watch 'date', (newValue, oldValue)->
		updateRemain(newValue)
		if newValue.getDay() in $scope.device.schedule.workday
			$scope.inWork = true
		else
			$scope.inWork = false
		return newValue
]

sciCtrl.controller 'confirmCtrl', ['$scope', '$modalInstance', 'Order', 'payload', ($scope, $modalInstance, Order, payload)->
	$scope.payload = payload

	$scope.order = ->
		Order.create($scope.payload).$promise.then ->
			alert('预约成功，你可以在个人中心跟踪订单状态')
			$modalInstance.close()
]

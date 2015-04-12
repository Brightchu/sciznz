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
		openModel($modal, $scope)

	$scope.scrollTo = (selector)->
		$document.scrollToElementAnimated($(document.querySelector(selector)), 100);

]

openModel = ($modal, $scope)->
	modalInstance = $modal.open
		templateUrl: '/static/partial/front/login.html'
		controller: 'loginCtrl'
		size: 'sm'
		windowClass: 'login'
		backdropClass: 'loginBack'

	modalInstance.result.then (name)->
		$scope.name = name

sciCtrl.controller 'loginCtrl', ['$scope', '$modalInstance', 'User', '$timeout', '$filter', ($scope, $modalInstance, User, $timeout, $filter)->
	signup = true
	$scope.actionText = $filter('translate')('signup')
	$scope.switchText = $filter('translate')('goSignin')

	signup = ->
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

	signin = ->
		form =
			email: $scope.email
			password: $scope.password

		promise = User.auth(form).$promise
		promise.catch ->
			$scope.error = true
		promise.then (data)->
			$modalInstance.close(data.name)

	$scope.switch = ->
		signup = !signup
		if signup
			$scope.actionText = $filter('translate')('signup')
			$scope.switchText = $filter('translate')('goSignin')
		else
			$scope.actionText = $filter('translate')('signin')
			$scope.switchText = $filter('translate')('goSignup')

	$scope.action = ->
		if signup
			signup()
		else
			signin()

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

sciCtrl.controller 'listCtrl', ['$scope', '$filter', 'data', ($scope, $filter, data)->
	$scope.data = data

	$scope.isCollapsed = true
	$scope.hideMoreFeature = true
	$scope.hideMoreCategory = true

	$scope.filterModel =
		domain: $filter('translate')('unlimit')
		feature: $filter('translate')('unlimit')
		category: $filter('translate')('unlimit')
		locale: $filter('translate')('unlimit')
		field: {}

	$scope.$watch 'filterModel.domain', (newValue, oldValue)->
		$scope.filterModel.feature = newValue
		$scope.filterModel.category = newValue

	$scope.$watch 'filterModel.feature', (newValue, oldValue)->
		$scope.filterModel.category = newValue
]

sciCtrl.controller 'deviceCtrl', ['$scope', '$routeParams', 'data', 'Device', 'Order', '$filter', '$cookies', '$modal', ($scope, $routeParams, data, Device, Order, $filter, $cookies, $modal)->
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
		if $cookies.name
			payload =
				deviceID: thisDevice.ID
				date: $filter('date')($scope.date, 'yyyy-MM-dd')
				method: $scope.orderModel.method
				resource: $scope.orderModel.resource
			if not payload.resource? and payload.method == 'RESOURCE'
				return alert('请选择预约项目')

			Order.create(payload).$promise.then ->
				alert('预约成功，你可以在个人中心跟踪订单状态')
				updateRemain($scope.date)
		else
			openModel($modal, $scope)

	updateRemain = (date)->
		payload =
			deviceID: thisDevice.ID
			date: $filter('date')(date, 'yyyy-MM-dd')
		Device.schedule(payload).$promise.then (body)->
			$scope.schedule = body
			$scope.orderModel =
				method: body.method[0]

	updateRemain(minDate)

	$scope.$watch 'date', (oldValue, newValue)->
		updateRemain(newValue)
		return newValue
]

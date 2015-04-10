'use strict'

sciCtrl = angular.module('sciCtrl', ['ngCookies', 'ui.bootstrap', 'ui.utils', 'duScroll'])

sciCtrl.controller 'navCtrl', ['$scope', '$modal', '$cookies', '$document', '$location', ($scope, $modal, $cookies, $document, $location)->
	$scope.name = $cookies.name || 'login'

	$scope.open = ->
		if $cookies.name?
			$location.url('/user')
		else
			login()

	login = ->
		modalInstance = $modal.open
			templateUrl: '/static/partial/front/login.html'
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
	$scope.current = 'signup'

	$scope.switchText = '去登录'
	$scope.actionText = '注册'

	$scope.signin = ->
		form =
			email: $scope.email
			password: $scope.password

		promise = User.auth(form).$promise
		promise.catch ->
			$scope.error = true
		promise.then (data)->
			$modalInstance.close(data.name)

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

	$scope.action = ->
		$scope[$scope.current]()

	$scope.switch = ->
		if $scope.current == 'signup'
			$scope.current = 'signin'
			$scope.switchText = '去注册'
			$scope.actionText = '登录'
		else
			$scope.current = 'signup'
			$scope.switchText = '去登录'
			$scope.actionText = '注册'
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
		address: $filter('translate')('unlimit')
		field: {}

	$scope.$watch 'filterModel.domain', (newValue, oldValue)->
		$scope.filterModel.feature = newValue
		$scope.filterModel.category = newValue

	$scope.$watch 'filterModel.feature', (newValue, oldValue)->
		$scope.filterModel.category = newValue
]

sciCtrl.controller 'deviceCtrl', ['$scope', '$routeParams', 'data', 'Order', '$filter', '$cookies', '$modal', ($scope, $routeParams, data, Order, $filter, $cookies, $modal)->
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
			d = $scope.date
			payload =
				deviceID: thisDevice.ID
				useDate: $filter('date')($scope.date, 'yyyy-MM-dd')
			Order.save(payload).$promise.then ->
				alert('预约成功，你可以在个人中心跟踪订单状态')
				$scope.stat.count += 1
		else
			modalInstance = $modal.open
				templateUrl: '/static/partial/front/login.html'
				controller: 'loginCtrl'
				size: 'sm'
				windowClass: 'login'
				backdropClass: 'loginBack'

			modalInstance.result.then (name)->
				$cookies.name = name
				$scope.name = name

	updateRemain = (useDate)->
		payload =
			deviceID: thisDevice.ID
			useDate: $filter('date')(useDate, 'yyyy-MM-dd')
		$scope.stat = Order.get(payload)

	updateRemain(minDate)

	$scope.$watch 'date', (oldValue, newValue)->
		updateRemain(newValue)
		return newValue
]
'use strict'

sciCtrl = angular.module('sciCtrl', ['ngCookies', 'ui.bootstrap', 'ui.utils'])

sciCtrl.controller 'navCtrl', ['$scope', '$modal', '$cookies', ($scope, $modal, $cookies)->
	$scope.name = $cookies.name || '登录'

	$scope.open = ->
		if $cookies.name?
			alert('Logined')
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
		$rootScope.groupSelected = $(this).text()
		location.hash = '#list'
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
		group: $rootScope.groupSelected || '全部类别'
		subgroup: '全部子类'
		address: '全部地点'
		category: '全部款式'
		field: {}

	$scope.moreSubGroup = []
	$scope.moreCateogory = []
]

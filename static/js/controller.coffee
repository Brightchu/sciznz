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

		modalInstance.result.then (res)->
			$scope.name = res.name
]

sciCtrl.controller 'loginCtrl', ['$scope', '$modalInstance', 'User', ($scope, $modalInstance, User)->
	$scope.signin = ->
		form =
			username: $scope.username
			password: $scope.password

		result = User.update(form).$promise
		result.catch (res)->
			$scope.error = true
		result.then (res)->
			$modalInstance.close(res)
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

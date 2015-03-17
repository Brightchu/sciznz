'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap', 'ui.utils'])

sciCtrl.controller 'navCtrl', ['$scope', '$modal', ($scope, $modal)->
	$scope.login = ->
		$(document.querySelector('body')).addClass('blur')
		modalInstance = $modal.open
			templateUrl: '/static/partial/login.html'
			controller: 'loginCtrl'
			size: 'sm'
			windowClass: 'login'
			backdropClass: 'loginBack'

		modalInstance.result.then (res)->
			console.log('OK')
			$(document.querySelector('body')).removeClass('blur')
			console.log('result')

]

sciCtrl.controller 'loginCtrl', ['$scope', '$modalInstance', ($scope, $modalInstance)->
	$scope.signin = ->
		form =
			username: $scope.username
			password: $scope.password

]


sciCtrl.controller 'homeCtrl', ['$scope', '$rootScope', 'data', ($scope, $rootScope, data)->
	$scope.groupList = data.hierarchy

	$(document).ready ->
		$(document.querySelectorAll('label')).on 'click', ->
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

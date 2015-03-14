'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap'])

sciCtrl.controller 'homeCtrl', ['$scope', '$rootScope', ($scope, $rootScope)->
	$scope.groupList = _data.hierarchy

	$(document).ready ->
		$(document.querySelectorAll('label')).on 'click', ->
			$rootScope.groupSelected = $(this).text()
			location.hash = '#list'
]

sciCtrl.controller 'listCtrl', ['$scope', '$rootScope', ($scope, $rootScope)->
	$scope.groupList = _data.hierarchy
	$scope.deviceList = _data.device
	$scope.addressList = _data.address
	$scope.isCollapsed = true
	$rootScope.field = {}

	$scope.filterModel =
		group: $rootScope.groupSelected || '全部类别'
		subgroup: '全部子类'
		address: '全部地点'
		category: '全部款式'
		field: {}

]

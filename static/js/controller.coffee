'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap', 'ui.utils'])

sciCtrl.controller 'homeCtrl', ['$scope', '$rootScope', 'data', ($scope, $rootScope, data)->
	$rootScope.setGroupList = (hierarchy)->
		$scope.groupList = hierarchy

	$(document).ready ->
		$(document.querySelectorAll('label')).on 'click', ->
			$rootScope.groupSelected = $(this).text()
			location.hash = '#list'

	$rootScope.setGroupList(data.hierarchy)
]

sciCtrl.controller 'listCtrl', ['$scope', '$rootScope', 'data', ($scope, $rootScope, data)->
	$scope.groupList = data.hierarchy
	$scope.deviceList = data.device
	$scope.addressList = data.address
	$scope.isCollapsed = true
	$rootScope.field = {}

	$scope.filterModel =
		group: $rootScope.groupSelected || '全部类别'
		subgroup: '全部子类'
		address: '全部地点'
		category: '全部款式'
		field: {}

]

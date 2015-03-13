'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap'])

sciCtrl.controller 'homeCtrl', ['$scope', '$rootScope', ($scope, $rootScope)->
	$scope.groupList = JSON.parse(localStorage.getItem('hierarchy'))

	$(document).ready ->
		$(document.querySelectorAll('label')).on 'click', ->
			$rootScope.groupSelected = $(this).text()
			location.hash = '#list'
]

sciCtrl.controller 'listCtrl', ['$scope', '$rootScope', ($scope, $rootScope)->
	$scope.groupList = JSON.parse(localStorage.getItem('hierarchy'))
	$scope.deviceList = JSON.parse(localStorage.getItem('data'))
	$scope.addressList = JSON.parse(localStorage.getItem('address'))
	$scope.isCollapsed = true

	$scope.filterModel =
		group: $rootScope.groupSelected || '全部类别'
		subgroup: '全部子类'
		address: '全部地点'
		model: '全部型号'
]

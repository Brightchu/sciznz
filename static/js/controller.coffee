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
	$scope.groupSelected = $rootScope.groupSelected || '全部仪器'
	console.log($scope.groupSelected)
]
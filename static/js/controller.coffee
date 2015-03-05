'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap'])
sciCtrl.controller 'welcomeCtrl', ['$scope', 'Query', ($scope, Query)->
	Query.get().$promise.then (data)->
		$scope.data = data
		$scope.group = data.group
		$scope.currentGroup = data.group[0].child

	$scope.enter = ->
		console.log('enter')

	$scope.leave = ->
		console.log('leave')
]

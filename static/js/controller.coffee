'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap'])
sciCtrl.controller 'welcomeCtrl', ['$scope', 'Query', ($scope, Query)->
	Query.get().$promise.then (data)->
		$scope.data = data
		console.log(data)

	$scope.enter = ->
		console.log 'enter'

	$scope.leave = ->
		console.log 'leave'
]

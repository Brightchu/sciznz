'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap'])
sciCtrl.controller 'navCtrl', ['$scope', ($scope)->
	$scope.enter = ->
		console.log 'enter'

	$scope.leave = ->
		console.log 'leave'
]

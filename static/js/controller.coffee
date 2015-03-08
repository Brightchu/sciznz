'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap'])
sciCtrl.controller 'welcomeCtrl', ['$scope', ($scope)->
	$scope.group = JSON.parse(localStorage.getItem('group'))
	$scope.currentGroup = $scope.group[0].child

]

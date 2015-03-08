'use strict'

sciCtrl = angular.module('sciCtrl', ['ui.bootstrap'])
sciCtrl.controller 'homeCtrl', ['$scope', ($scope)->
	$scope.group = JSON.parse(localStorage.getItem('group'))
	$scope.currentGroup = $scope.group[0].child
]

sciCtrl.controller 'categoryCtrl', ['$scope', '$routeParams', ($scope, $routeParams)->
	categoryMap = JSON.parse(localStorage.getItem('categoryMap'))
	$scope.categoryName = $routeParams.categoryName
	thisID = categoryMap[$routeParams.categoryName]
	thisCategory = JSON.parse(localStorage.getItem('model')).filter (value)->
		return value.categoryID == thisID

]

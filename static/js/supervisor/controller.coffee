'use strict'

supervisorCtrl = angular.module('supervisorCtrl', ['ui.bootstrap', 'ui.grid', 'ui.grid.edit', 'ui.grid.rowEdit', 'ui.grid.cellNav'])

supervisorCtrl.controller 'AccordionCtrl', ['$scope', ($scope)->
	$scope.isFirstOpen = true

	angular.element(document).ready ->
		angular.element(document.querySelector('.panel-heading')).addClass('open')
		angular.element(document.querySelector('.panel-group p')).addClass('active')

		heading = angular.element(document.querySelectorAll('.panel-heading'))
		heading.on 'click', ->
			heading.removeClass('open')
			angular.element(this).addClass('open')

		entry = angular.element(document.querySelectorAll('.panel-group p'))
		entry.on 'click', ->
			entry.removeClass('active')
			angular.element(this).addClass('active')
]

supervisorCtrl.controller 'adminCtrl', ['$scope', 'Admin', ($scope, Admin)->
	$scope.gridOptions =
		enableFiltering: true
		columnDefs: [
			{name: 'ID', enableCellEdit: false},
			{name: 'privilege'},
			{name: 'name'},
			{name: 'username'},
			{name: 'password'},
			{name: 'phone'},
			{name: 'email'},
			{name: 'credit'},
		]
		data: Admin.query()

	$scope.addRow = ->
		$scope.gridOptions.data.push
			'ID': 'New'
			'privilege': ''
			'name': ''
			'username': ''
			'password': ''
			'phone': ''
			'email': ''
			'credit': ''

	$scope.saveRow = (row)->
		if row.ID == 'New'
			promise = Admin.save(row)
		else
			promise = Admin.update(row)
		$scope.gridApi.rowEdit.setSavePromise(row, promise.$promise)

	$scope.flushDirtyRows = ->
		$scope.gridApi.rowEdit.flushDirtyRows()

	$scope.deleteRow = ->
		row = $scope.gridApi.cellNav.getFocusedCell().row.entity
		Admin.delete(row)

		index = $scope.gridOptions.data.indexOf(row)
		$scope.gridOptions.data.splice(index, 1)

	$scope.gridOptions.onRegisterApi = (gridApi)->
		$scope.gridApi = gridApi
		gridApi.rowEdit.on.saveRow($scope, $scope.saveRow)
]

'use strict'

supervisorCtrl = angular.module('supervisorCtrl', ['ui.bootstrap', 'ui.grid', 'ui.grid.edit', 'ui.grid.rowEdit', 'ui.grid.cellNav'])
supervisorCtrl.controller 'AccordionCtrl', ['$scope', '$location', ($scope, $location)->
	$(document).ready ->
		heading = $(document.querySelectorAll('.panel-heading'))
		heading.on 'click', ->
			heading.removeClass('open')
			$(this).addClass('open')

		entry = $(document.querySelectorAll('.panel-group p'))
		entry.on 'click', ->
			entry.removeClass('active')
			$(this).addClass('active')

		link = $(document.querySelector("[href='##{$location.path()}']"))
		link.parent().click()
		$($(link.parent().parent().parent().parent().children()[0]).children()[0]).children().click()
]

supervisorCtrl.controller 'peopleAdminCtrl', ['$scope', 'Admin', ($scope, Admin)->
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

supervisorCtrl.controller 'peopleOperatorCtrl', ['$scope', 'Staff', ($scope, Staff)->
	$scope.gridOptions =
		enableFiltering: true
		columnDefs: [
			{name: 'ID', enableCellEdit: false},
			{name: 'orgID'},
			{name: 'name'},
			{name: 'username'},
			{name: 'password'},
			{name: 'phone'},
			{name: 'email'},
			{name: 'credit'},
		]
		data: Staff.query()

	$scope.addRow = ->
		$scope.gridOptions.data.push
			'ID': 'New'
			'orgID': ''
			'name': ''
			'username': ''
			'password': ''
			'phone': ''
			'email': ''
			'credit': ''

	$scope.saveRow = (row)->
		if row.ID == 'New'
			promise = Staff.save(row)
		else
			promise = Staff.update(row)
		$scope.gridApi.rowEdit.setSavePromise(row, promise.$promise)

	$scope.flushDirtyRows = ->
		$scope.gridApi.rowEdit.flushDirtyRows()

	$scope.deleteRow = ->
		row = $scope.gridApi.cellNav.getFocusedCell().row.entity
		Staff.delete(row)

		index = $scope.gridOptions.data.indexOf(row)
		$scope.gridOptions.data.splice(index, 1)

	$scope.gridOptions.onRegisterApi = (gridApi)->
		$scope.gridApi = gridApi
		gridApi.rowEdit.on.saveRow($scope, $scope.saveRow)
]

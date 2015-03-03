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

gridBuilder = ($scope, Model, columnDefs)->
	$scope.gridOptions =
		enableFiltering: true
		columnDefs: columnDefs
		data: Model.query()

	$scope.addRow = ->
		$scope.gridOptions.data.push
			'ID': 'New'

	$scope.saveRow = (row)->
		if row.ID == 'New'
			promise = Model.save(row)
		else
			promise = Model.update(row)
		$scope.gridApi.rowEdit.setSavePromise(row, promise.$promise)

	$scope.flushDirtyRows = ->
		$scope.gridApi.rowEdit.flushDirtyRows()

	$scope.deleteRow = ->
		row = $scope.gridApi.cellNav.getFocusedCell().row.entity
		Model.delete(row)

		index = $scope.gridOptions.data.indexOf(row)
		$scope.gridOptions.data.splice(index, 1)

	$scope.gridOptions.onRegisterApi = (gridApi)->
		$scope.gridApi = gridApi
		gridApi.rowEdit.on.saveRow($scope, $scope.saveRow)

supervisorCtrl.controller 'peopleUserCtrl', ['$scope', 'User', ($scope, User)->
	$scope.title = '用户管理'
	gridBuilder.call(this, $scope, User, [
		{name: 'ID', enableCellEdit: false}
		{name: 'name'}
		{name: 'username'}
		{name: 'password'}
		{name: 'phone'}
		{name: 'email'}
		{name: 'credit'}
	])
]

supervisorCtrl.controller 'peopleOperatorCtrl', ['$scope', 'Staff', ($scope, Staff)->
	$scope.title = '操作员管理'
	gridBuilder.call(this, $scope, Staff, [
		{name: 'ID', enableCellEdit: false}
		{name: 'orgID'}
		{name: 'name'}
		{name: 'username'}
		{name: 'password'}
		{name: 'phone'}
		{name: 'email'}
		{name: 'credit'}
	])
]

supervisorCtrl.controller 'peopleSupervisorCtrl', ['$scope', 'Admin', ($scope, Admin)->
	$scope.title = '监督员管理'
	gridBuilder.call(this, $scope, Admin, [
		{name: 'ID', enableCellEdit: false}
		{name: 'privilege'}
		{name: 'name'}
		{name: 'username'}
		{name: 'password'}
		{name: 'phone'}
		{name: 'email'}
		{name: 'credit'}
	])
]

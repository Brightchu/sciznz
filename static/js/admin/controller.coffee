'use strict'

adminCtrl = angular.module('adminCtrl', ['ui.bootstrap', 'ui.grid', 'ui.grid.edit', 'ui.grid.rowEdit', 'ui.grid.cellNav'])
adminCtrl.controller 'accordionCtrl', ['$scope', '$location', ($scope, $location)->
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

adminCtrl.controller 'categoryAdmin', ['$scope', 'Category', ($scope, Category)->
	$scope.title = '分类管理'
	gridBuilder.call(this, $scope, Category, [
		{name: 'ID', enableCellEdit: false}
		{name: 'name'}
		{name: 'info'}
	])
]

adminCtrl.controller 'categoryField', ['$scope', 'CategoryField', ($scope, CategoryField)->
	$scope.title = '类别参数'
	gridBuilder.call(this, $scope, CategoryField, [
		{name: 'ID', enableCellEdit: false}
		{name: 'categoryID'}
		{name: 'name'}
		{name: 'weight'}
	])
]

adminCtrl.controller 'categoryKeyword', ['$scope', 'CategoryKeyword', ($scope, CategoryKeyword)->
	$scope.title = '类别关键词'
	gridBuilder.call(this, $scope, CategoryKeyword, [
		{name: 'ID', enableCellEdit: false}
		{name: 'categoryID'}
		{name: 'name'}
		{name: 'level'}
	])
]

adminCtrl.controller 'modelAdmin', ['$scope', 'Model', ($scope, Model)->
	$scope.title = '型号管理'
	gridBuilder.call(this, $scope, Model, [
		{name: 'ID', enableCellEdit: false}
		{name: 'categoryID'}
		{name: 'name'}
		{name: 'info'}
	])
]

adminCtrl.controller 'modelField', ['$scope', 'ModelField', ($scope, ModelField)->
	$scope.title = '型号参数'
	gridBuilder.call(this, $scope, ModelField, [
		{name: 'ID', enableCellEdit: false}
		{name: 'categoryID'}
		{name: 'name'}
		{name: 'value'}
	])
]

adminCtrl.controller 'modelKeyword', ['$scope', 'ModelKeyword', ($scope, ModelKeyword)->
	$scope.title = '型号关键词'
	gridBuilder.call(this, $scope, ModelKeyword, [
		{name: 'ID', enableCellEdit: false}
		{name: 'categoryID'}
		{name: 'name'}
		{name: 'weight'}
	])
]

adminCtrl.controller 'peopleUserCtrl', ['$scope', 'User', ($scope, User)->
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

adminCtrl.controller 'peopleStaffCtrl', ['$scope', 'Operator', ($scope, Operator)->
	$scope.title = '操作员管理'
	gridBuilder.call(this, $scope, Operator, [
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

adminCtrl.controller 'peopleAdminCtrl', ['$scope', 'Supervisor', ($scope, Supervisor)->
	$scope.title = '监督员管理'
	gridBuilder.call(this, $scope, Supervisor, [
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

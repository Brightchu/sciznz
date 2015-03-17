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

adminCtrl.controller 'dataOverview', ['$scope', ($scope)->
	$scope.title = '全局'
]

adminCtrl.controller 'dataVisitor', ['$scope', ($scope)->
	$scope.title = '访客统计'
]

adminCtrl.controller 'dataBooking', ['$scope', ($scope)->
	$scope.title = '预约统计'
]

adminCtrl.controller 'dataPayment', ['$scope', ($scope)->
	$scope.title = '支付统计'
]

adminCtrl.controller 'frontGroup', ['$scope', 'FrontGroup', ($scope, FrontGroup)->
	$scope.title = '分组管理'
	$scope.editor = new JSONEditor(document.querySelector('#jsoneditor'))

	FrontGroup.query().$promise.then (data)->
		$scope.editor.set(data)

	$scope.save = ->
		FrontGroup.update($scope.editor.get()).$promise.then ->
			alert('保存成功')

]

adminCtrl.controller 'frontCategory', ['$scope', 'FrontCategory', ($scope, FrontCategory)->
	$scope.title = '分类管理'
	gridBuilder.call(this, $scope, FrontCategory, [
		{name: 'ID', enableCellEdit: false}
		{name: 'name'}
		{name: 'field'}
		{name: 'info'}
	])
]

adminCtrl.controller 'frontModel', ['$scope', 'FrontModel', ($scope, FrontModel)->
	$scope.title = '型号管理'
	gridBuilder.call(this, $scope, FrontModel, [
		{name: 'ID', enableCellEdit: false}
		{name: 'categoryID'}
		{name: 'vendor'}
		{name: 'name'}
		{name: 'field'}
		{name: 'info'}
	])
]

adminCtrl.controller 'frontDevice', ['$scope', 'FrontDevice', ($scope, FrontDevice)->
	$scope.title = '仪器管理'
	gridBuilder.call(this, $scope, FrontDevice, [
		{name: 'ID', enableCellEdit: false}
		{name: 'modelID'}
		{name: 'instituteID'}
		{name: 'city'}
		{name: 'location'}
		{name: 'address'}
		{name: 'price'}
		{name: 'unit'}
		{name: 'field'}
		{name: 'info'}
		{name: 'credit'}
		{name: 'online'}
	])
]

adminCtrl.controller 'frontCache', ['$scope', 'FrontCache', ($scope, FrontCache)->
	$scope.update = ->
		FrontCache.update().$promise.then ->
			alert('重建缓存成功')
]

adminCtrl.controller 'cacheAdmin', ['$scope', 'CacheAdmin', ($scope, CacheAdmin)->
	$scope.title = '缓存管理'

	$scope.gridOptions =
		enableFiltering: true
		data: CacheAdmin.query()

	$scope.addRow = ->
		$scope.gridOptions.data.push
			'key': 'New'

	$scope.saveRow = (row)->
		promise = CacheAdmin.update(row)
		$scope.gridApi.rowEdit.setSavePromise(row, promise.$promise)

	$scope.flushDirtyRows = ->
		$scope.gridApi.rowEdit.flushDirtyRows()

	$scope.deleteRow = ->
		row = $scope.gridApi.cellNav.getFocusedCell().row.entity
		CacheAdmin.delete
			'key': row.key

		index = $scope.gridOptions.data.indexOf(row)
		$scope.gridOptions.data.splice(index, 1)

	$scope.gridOptions.onRegisterApi = (gridApi)->
		$scope.gridApi = gridApi
		gridApi.rowEdit.on.saveRow($scope, $scope.saveRow)
]

adminCtrl.controller 'instituteAdmin', ['$scope', 'Institute', ($scope, Institute)->
	$scope.title = '机构管理'
	gridBuilder.call(this, $scope, Institute, [
		{name: 'ID', enableCellEdit: false}
		{name: 'chief'}
		{name: 'name'}
		{name: 'info'}
	])
]

adminCtrl.controller 'peopleUser', ['$scope', 'User', ($scope, User)->
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

adminCtrl.controller 'peopleStaff', ['$scope', 'Operator', ($scope, Operator)->
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

adminCtrl.controller 'peopleAdmin', ['$scope', 'Supervisor', ($scope, Supervisor)->
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

adminCtrl.controller 'bookingAdmin', ['$scope', ($scope)->
	$scope.title = '预约管理'
]

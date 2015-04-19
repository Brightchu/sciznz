'use strict'

adminCtrl = angular.module('adminCtrl', ['ngCookies', 'ui.bootstrap', 'ui.grid', 'ui.grid.edit', 'ui.grid.rowEdit', 'ui.grid.cellNav'])

adminCtrl.controller 'topCtrl', ['$scope', 'Admin', ($scope, Admin)->
	$scope.info = Admin.info()
]

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

adminCtrl.controller 'frontHierarchy', ['$scope', 'FrontHierarchy', ($scope, FrontHierarchy)->
	$scope.title = '层级管理'
	$scope.editor = new JSONEditor(document.querySelector('#jsoneditor'))
	
	FrontHierarchy.get().$promise.then (data)->
		local = {}
		for name, value of data
			if name.indexOf('$') == -1
				local[name] = value
		$scope.editor.set(local)

	$scope.save = ->
		FrontHierarchy.update($scope.editor.get()).$promise.then ->
			alert('保存成功')
		, ->
			alert('保存失败')

]

adminCtrl.controller 'frontCategory', ['$scope', 'FrontCategory', ($scope, FrontCategory)->
	$scope.title = '分类管理'
	gridBuilder.call(this, $scope, FrontCategory, [
		{name: 'ID', enableCellEdit: false}
		{name: 'name'}
		{name: 'field'}
	])
]

adminCtrl.controller 'frontModel', ['$scope', 'FrontModel', ($scope, FrontModel)->
	$scope.title = '型号管理'
	gridBuilder.call(this, $scope, FrontModel, [
		{name: 'ID', enableCellEdit: false}
		{name: 'categoryID'}
		{name: 'name'}
		{name: 'field'}
		{name: 'img'}
		{name: 'spec'}
	])
]

adminCtrl.controller 'frontDevice', ['$scope', 'FrontDevice', ($scope, FrontDevice)->
	$scope.title = '仪器管理'
	gridBuilder.call(this, $scope, FrontDevice, [
		{name: 'ID', enableCellEdit: false}
		{name: 'modelID'}
		{name: 'supplyID'}
		{name: 'field'}
		{name: 'info'}
		{name: 'img'}
		{name: 'spec'}
		{name: 'schedule'}
		{name: 'contract'}
		{name: 'memo'}
		{name: 'online'}
	])
]

adminCtrl.controller 'frontCache', ['$scope', 'FrontCache', ($scope, FrontCache)->
	$scope.update = ->
		FrontCache.update().$promise.then ->
			alert('重建缓存成功')
		, ->
			alert('重建缓存失败')
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

adminCtrl.controller 'peopleUser', ['$scope', 'User', ($scope, User)->
	$scope.title = '用户管理'
	gridBuilder.call(this, $scope, User, [
		{name: 'ID', enableCellEdit: false}
		{name: 'name'}
		{name: 'email'}
		{name: 'password'}
		{name: 'phone'}
	])
]

adminCtrl.controller 'peopleSupply', ['$scope', 'Supply', ($scope, Supply)->
	$scope.title = '供应商管理'
	gridBuilder.call(this, $scope, Supply, [
		{name: 'ID', enableCellEdit: false}
		{name: 'name'}
		{name: 'email'}
		{name: 'password'}
		{name: 'phone'}
		{name: 'city'}
		{name: 'locale'}
		{name: 'address'}
		{name: 'memo'}
	])
]

adminCtrl.controller 'peopleGroup', ['$scope', 'Group', ($scope, Group)->
	$scope.title = '科研团体管理'
	gridBuilder.call(this, $scope, Group, [
		{name: 'ID', enableCellEdit: false}
		{name: 'name'}
		{name: 'email'}
		{name: 'password'}
		{name: 'phone'}
	])
]

adminCtrl.controller 'peopleHelper', ['$scope', 'Helper', ($scope, Helper)->
	$scope.title = '客服管理'
	gridBuilder.call(this, $scope, Helper, [
		{name: 'ID', enableCellEdit: false}
		{name: 'name'}
		{name: 'email'}
		{name: 'password'}
		{name: 'phone'}
	])
]

adminCtrl.controller 'peopleAdmin', ['$scope', 'Admin', ($scope, Admin)->
	$scope.title = '管理员管理'
	gridBuilder.call(this, $scope, Admin, [
		{name: 'ID', enableCellEdit: false}
		{name: 'name'}
		{name: 'email'}
		{name: 'password'}
		{name: 'phone'}
	])
]

adminCtrl.controller 'bookingAdmin', ['$scope', ($scope)->
	$scope.title = '预约管理'
]

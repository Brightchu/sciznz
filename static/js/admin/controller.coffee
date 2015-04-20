'use strict'

adminCtrl = angular.module('adminCtrl', ['ngCookies', 'ui.bootstrap', 'ui.grid', 'ui.grid.edit', 'ui.grid.rowEdit', 'ui.grid.cellNav'])

adminCtrl.controller 'topCtrl', ['$scope', 'Admin', ($scope, Admin)->
	$scope.info = Admin.info()
]

adminCtrl.controller 'accordionCtrl', ['$scope', '$location', '$cookies', ($scope, $location, $cookies)->
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

	$scope.logout = ->
		if confirm('退出当前账号？')
			for key, value of $cookies
				delete $cookies[key]
			window.location = '/admin/login'
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

adminCtrl.controller 'frontAdd', ['$scope', 'FrontCategory', 'FrontModel', 'FrontDevice', 'Supply', ($scope, FrontCategory, FrontModel, FrontDevice, Supply)->
	$scope.thisCategory =
		name: '请选择分类'
	$scope.newCategory =
		name: '新分类'
		field: ['新指标']
	$scope.thisModel =
		name: '请选择型号'

	$scope.thisSupply =
		name: '请选择供应商'
	$scope.thisDevice =
		addfield: []
		img: ''
		spec: '{}'
		method: {}
		workday:
			d1: true
			d2: true
			d3: true
			d4: true
			d5: true
			d6: false
			d7: false
		unlimited:
			price: 0
			unit: '元'
		resource: []
		online: true

	modelList = []
	FrontModel.query().$promise.then (data)->
		for model in data
			model.field = JSON.parse(model.field)
			model.spec = JSON.parse(model.spec)
		modelList = data

	$scope.categoryList = FrontCategory.query()
	$scope.supplyList = Supply.query()

	$scope.modelDisabled = true
	$scope.deviceDisabled = true

	$scope.onCategoryClick = (category)->
		$scope.thisCategory = this.category || category
		$scope.modelDisabled = false
		$scope.modelList = modelList.filter (model)->
			model.categoryID == $scope.thisCategory.ID

	$scope.addNewField = ->
		$scope.newCategory.field.push('新指标')

	$scope.saveNewCategory = ->
		payload =
			name: $scope.newCategory.name
			field: JSON.stringify($scope.newCategory.field)
		FrontCategory.save(payload).$promise.then ->
			$scope.categoryList.push($scope.newCategory)
			$scope.thisCategory = $scope.newCategory
			$scope.showNewCategory = false
			$scope.onCategoryClick($scope.newCategory)
		, ->
			alert('保存失败')

	$scope.onModelClick = (model)->
		$scope.thisModel = this.model || model
		$scope.deviceDisabled = false

	$scope.addNewModel = ->
		fieldMap = {}
		for field in JSON.parse($scope.thisCategory.field)
			fieldMap[field] = ''
		$scope.newModel =
			categoryID: $scope.thisCategory.ID
			name: '新型号'
			field: fieldMap
			addfield: []
			img: ''
			spec: '{}'
		$scope.showNewModel = true

	$scope.newModelAddField = ->
		$scope.newModel.addfield.push
			name: '新指标'
			value: '新参数'

	$scope.saveNewModel = ->
		for addfield in $scope.newModel.addfield
			$scope.newModel.field[addfield.name] = addfield.value

		payload = angular.copy($scope.newModel)
		payload.field = JSON.stringify(payload.field)

		FrontModel.save(payload).$promise.then ->
			$scope.modelList.push($scope.newModel)
			$scope.thisModel = $scope.newModel
			$scope.showNewModel = false
			$scope.onModelClick($scope.newModel)
		, ->
			alert('保存失败')

	$scope.onSupplyClick = ->
		$scope.thisSupply = this.supply

	$scope.addField = ->
		$scope.thisDevice.addfield.push
			name: '新指标'
			value: '新参数'

	$scope.addResource = ->
		$scope.thisDevice.resource.push
			name: '新项目'
			price: '0'
			unit: '元'
			capacity: '1'

	$scope.stage = ->
		field = {}
		for addfield in $scope.thisDevice.addfield
			field[addfield.name] = addfield.value

		schedule =
			method: []
			workday: []
			unlimited: $scope.thisDevice.unlimited
			resource: {}

		for res in $scope.thisDevice.resource
			schedule.resource[res.name] =
				price: res.price
				unit: res.unit
				capacity: res.capacity
				count: 0

		if $scope.thisDevice.method.resource
			schedule.method.push('RESOURCE')
		if $scope.thisDevice.method.unlimited
			schedule.method.push('UNLIMITED')

		for day, status of $scope.thisDevice.workday
			if status
				schedule.workday.push(parseInt(day.charAt(1)))

		payload =
			modelID: $scope.thisModel.ID
			supplyID: $scope.thisSupply.ID
			field: JSON.stringify(field)
			info: $scope.thisDevice.info
			img: $scope.thisDevice.img
			spec: $scope.thisDevice.spec
			schedule: JSON.stringify(schedule)
			contract: $scope.thisDevice.contract
			memo: $scope.thisDevice.memo
			online: $scope.thisDevice.online

		FrontDevice.save(payload).$promise.then ->
			alert('保存成功')
			window.location.reload()
		, ->
			alert('保存失败')
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

adminCtrl.controller 'orderAdmin', ['$scope', ($scope)->
	$scope.title = '预约管理'
]

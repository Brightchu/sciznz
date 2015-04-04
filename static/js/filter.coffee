'use strict'

sciFilter = angular.module('sciFilter', [])

'''
sciFilter.filter 'listFilter', ['data', (data)->
	(array, filterModel)->
		# build condition
		condition = {}
		condition['category'] = filterModel.category if filterModel.category != '全部款式'
		condition['address'] = filterModel.address if filterModel.address != '全部地点'

		array = array.filter (value)->
			for name, want of condition
				if value[name] != want
					return false

			return true

		# build condition
		condition = {}
		condition['group'] = filterModel.group if filterModel.group != '全部类别'
		condition['subgroup'] = filterModel.subgroup if filterModel.subgroup != '全部子类'

		array = array.filter (value)->
			for name, want of condition
				return false if value.category not in data.keyword[want]

			return true

		if filterModel.group != '全部类别' and filterModel.subgroup == '全部子类'
			array = array.filter (value)->
				return value.category in data.keyword[filterModel.group]

		if filterModel.subgroup != '全部子类'
			array = array.filter (value)->
				return value.category in data.keyword[filterModel.subgroup]

		# filter field
		# build condition
		condition = {}
		for name, want of filterModel.field
			if want != '全部取值'
				condition[name] = want

		# do filter field
		array = array.filter (value)->
			for name, want of condition
				if value.field[name] != want
					return false

			return true

		return array
]

'''
sciFilter.filter 'featureFilter', ['$filter', ($filter)->
	memo = {}

	(hierarchy, filterModel, $scope)->
		_memo = memo[filterModel.domain]
		if not _memo?
			_all = []
			if filterModel.domain == $filter('translate')('all')
				for _, domain of hierarchy
					for feature of domain
						_all.push(feature)
			else
				for feature of hierarchy[filterModel.domain]
					_all.push(feature)

			_memo =
				self: _all[0...7]
				more: []

			for i in [7..._all.length] by 7
				_memo.more.push(_all[i...i+7])

			memo[filterModel.domain] = _memo

		$scope.moreFeature = _memo.more
		return _memo.self
]

'''
sciFilter.filter 'categoryFilter', ['data', (data)->
	(array, filterModel)->
		if filterModel.group == '全部类别' and filterModel.subgroup == '全部子类'
			return data.category

		if filterModel.subgroup == '全部子类'
			return data.keyword[filterModel.group]

		return data.keyword[filterModel.subgroup]
]

sciFilter.filter 'fieldFilter', ['$rootScope', 'data', ($rootScope, data)->
	(array, filterModel)->
		if filterModel.category == '全部款式'
			return

		deviceList = data.device.filter (value)->
			return value.category == filterModel.category

		field = {}
		for device in deviceList
			for key, value of device.field
				if not field[key]?
					field[key] = {}
				field[key][value] = true

		if not angular.equals($rootScope.field, field)
			$rootScope.field = field

		for item of deviceList[0].field
			if not filterModel.field[item]?
				filterModel.field[item] = '全部取值'

		return $rootScope.field
]
'''

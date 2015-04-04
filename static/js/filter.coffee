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

sciFilter.filter 'moreSubGroupFilter', ->
	(array, $scope)->
		slices = []
		if $scope.showMoreSubGroup
			for i in [7...array.length] by 7
				slices.push(array[i...i+7])

		if not angular.equals($scope.moreSubGroup, slices)
			$scope.moreSubGroup = slices

		return array[0...7]

sciFilter.filter 'moreCategoryFilter', ->
	(array, $scope)->
		slices = []
		if $scope.showMoreCategory
			for i in [6...array.length] by 6
				slices.push(array[i...i+6])

		if not angular.equals($scope.moreCateogory, slices)
			$scope.moreCateogory = slices

		return array[0...6]
'''
sciFilter.filter 'featureFilter', ['$filter', ($filter)->
	memo = {}

	(hierarchy, filterModel)->
		_memo = memo[filterModel.domain]
		return _memo if _memo?

		_memo = {}
		if filterModel.domain == $filter('translate')('all')
			for domain, feature of hierarchy
				angular.extend(_memo, feature)
		else
			angular.extend(_memo, hierarchy[filterModel.domain])

		memo[filterModel.domain] = _memo
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

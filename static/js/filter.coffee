'use strict'

sciFilter = angular.module('sciFilter', [])
sciFilter.filter 'listFilter', ->
	(data, filterModel)->
		#filter address
		if filterModel.address != '全部地点'
			data = data.filter (value)->
				return value.address == filterModel.address

		# by pass all group
		if filterModel.group == '全部类别'
			return data || data

		# filter subgroup
		if filterModel.subgroup == '全部子类'
			data = data.filter (value)->
				return value.category in _data.keyword[filterModel.group]
		else
			data = data.filter (value)->
				return value.category in _data.keyword[filterModel.subgroup]

		# filter category
		if filterModel.category != '全部款式'
			data = data.filter (value)->
				return value.category == filterModel.category

		return data

sciFilter.filter 'subgroupFilter', ->
	(data, filterModel)->
		if filterModel.group == '全部类别'
			return

		group = data.filter (value)->
			return value.name == filterModel.group

		return group[0].child

sciFilter.filter 'categoryFilter', ->
	(data, filterModel)->
		if filterModel.group == '全部类别'
			return

		if filterModel.subgroup == '全部子类'
			return _data.keyword[filterModel.group]

		return _data.keyword[filterModel.subgroup]

sciFilter.filter 'fieldFilter', ['$rootScope', ($rootScope)->
	(data, filterModel)->
		if filterModel.category == '全部款式'
			return

		deviceList = _data.device.filter (value)->
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
			if not filterModel[item]?
				filterModel[item] = '全部取值'

		console.log(filterModel)
		return $rootScope.field

]
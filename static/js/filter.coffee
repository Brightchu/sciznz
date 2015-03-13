'use strict'

sciFilter = angular.module('sciFilter', [])
_filter = JSON.parse(localStorage.getItem('filter'))
sciFilter.filter 'listFilter', ->
	(data, filterModel)->
		#filter address
		if filterModel.address != '全部地点'
			data = data.filter (value)->
				return value.address == filterModel.address

		# by pass all group
		if filterModel.group == '全部类别'
			return data

		# filter subgroup
		if filterModel.subgroup == '全部子类'
			data = data.filter (value)->
				return value.category in _filter[filterModel.group]
		else
			data = data.filter (value)->
				return value.category in _filter[filterModel.subgroup]

		# filter model
		if filterModel.model != '全部型号'
			data = data.filter (value)->
				return value.category == filterModel.model

		return data

sciFilter.filter 'subgroupFilter', ->
	(data, filterModel)->
		if filterModel.group == '全部类别'
			return

		group = data.filter (value)->
			return value.name == filterModel.group

		return group[0].child

sciFilter.filter 'modelFilter', ->
	(data, filterModel)->
		if filterModel.group == '全部类别'
			return

		if filterModel.subgroup == '全部子类'
			return _filter[filterModel.group]

		return _filter[filterModel.subgroup]

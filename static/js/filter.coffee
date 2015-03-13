'use strict'

sciFilter = angular.module('sciFilter', [])
sciFilter.filter 'listFilter', ->
	filter = JSON.parse(localStorage.getItem('filter'))

	(array, filterModel)->
		if filterModel.group == '全部类别'
			return array

		if filterModel.subgroup == '全部子类'
			result = array.filter (value)->
				return value.category in filter[filterModel.group]
		else
			result = array.filter (value)->
				return value.category in filter[filterModel.subgroup]
		return result

sciFilter.filter 'subgroupFilter', ->
	(array, filterModel)->
		if filterModel.group == '全部类别'
			return

		group = array.filter (value)->
			return value.name == filterModel.group

		return group[0].child

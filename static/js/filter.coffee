'use strict'

sciFilter = angular.module('sciFilter', [])

sciFilter.filter 'listFilter', ['$filter', ($filter)->
	(data, filterModel)->
		# return if no filter label selected
		if filterModel.category == $filter('translate')('unlimit')
			return data.device

		# selected category
		IDList = data.index.contain[filterModel.category]
		if IDList?
			deviceList = IDList.map (deviceID)->
					data.device[deviceID]
		else
			return []

		# filter field
		# build condition
		condition = {}
		for name, expect of filterModel.field
			if expect != $filter('translate')('unlimit')
				condition[name] = expect

		# do filter field
		deviceList = deviceList.filter (device)->
			for name, expect of condition
				if device.field[name] != expect
					return false

			return true


		return deviceList
]


sciFilter.filter 'fieldFilter', ['$filter', ($filter)->
	(data, filterModel, field)->
		if not filterModel.field[field]?
			filterModel.field[field] = $filter('translate')('unlimit')

		IDList = data.index.contain[filterModel.category]
		if IDList?
			return IDList.map (deviceID)->
				data.device[deviceID]['field'][field]
		else
			return []
]

'use strict'

sciFilter = angular.module('sciFilter', [])

sciFilter.filter 'listFilter', ['$filter', ($filter)->
	(data, filterModel, $scope)->
		# return if no filter label selected
		if filterModel.category == $filter('translate')('unlimit')
			if filterModel.address == $filter('translate')('unlimit')
				return data.device
			else
				deviceList = []
				for _, device of data.device
					if device.address == filterModel.address
						deviceList.push(device)

				return deviceList

		# selected category
		IDList = data.index.contain[filterModel.category]
		if IDList?
			deviceList = IDList.map (deviceID)->
					data.device[deviceID]
		else
			$scope.nodevice = true
			return []

		# filter address
		if filterModel.address != $filter('translate')('unlimit')
			deviceList = deviceList.filter (device)->
				if device.address == filterModel.address
					return true
				else
					return false

		# filter field
		# build condition
		condition = {}
		for name, expect of filterModel.field
			if expect != $filter('translate')('unlimit')
				condition[name] = expect

		# do filter field
		if condition?
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

'use strict'

sciFilter = angular.module('sciFilter', [])

sciFilter.filter 'listFilter', ['$filter', ($filter)->
	(data, filterModel, $scope)->
		# return if no filter label selected
		if filterModel.category == $filter('translate')('unlimit')
			if filterModel.locale == $filter('translate')('unlimit')
				return data.device
			else
				deviceList = []
				for _, device of data.device
					if device.locale == filterModel.locale
						deviceList.push(device)

				return deviceList

		# selected category
		IDList = data.index.contain[filterModel.category]
		if IDList?
			deviceList = IDList.map (deviceID)->
				data.device[deviceID]
		else
			return []

		# filter locale
		if filterModel.locale != $filter('translate')('unlimit')
			deviceList = deviceList.filter (device)->
				if device.locale == filterModel.locale
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

sciFilter.filter 'keywordFilter', ->
	(data, $scope)->
		if angular.isArray(data)
			if $scope.keyword? and $scope.keyword.length
				result = data.filter (device)->
					return JSON.stringify(device).indexOf($scope.keyword) != -1
				$scope.nodevice = (result.length == 0)
				return result
			else
				$scope.nodevice = (data.length == 0)
				return data
		else
			if $scope.keyword? and $scope.keyword.length
				result = []
				for _, device of data
					if JSON.stringify(device).indexOf($scope.keyword) != -1
						result.push(device)
				$scope.nodevice = (result.length == 0)
				return result
			else
				$scope.nodevice = false
				return data

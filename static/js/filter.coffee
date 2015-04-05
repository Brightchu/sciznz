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

sciFilter.filter 'fieldFilter', ['$filter', ($filter)->
	(data, filterModel, field)->
		'''
		if filterModel.domain == $filter('translate')('unlimit')
			for domain, domainFeature of data.hierarchy
				for feature, featureCategory of domainFeature
					for category of featureCategory
						if category == filterModel.category
							filterModel.feature = feature
							filterModel.domain = domain
							break

		else if filterModel.feature == $filter('translate')('unlimit')
			for feature, featureCategory of data.hierarchy[filterModel.domain]
				for category of featureCategory
					if category == filterModel.category
						filterModel.feature = feature
						break
		'''

		filterModel.field[field] = $filter('translate')('unlimit')

		IDList = data.index.contain[filterModel.category]
		if IDList?
			return IDList.map (deviceID)->
				return data.device[deviceID]['field'][field]
		else
			return []
]

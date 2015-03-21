'use strict'

providerFilter = angular.module('providerFilter', [])
providerFilter.filter 'statusFilter', ->
	name =
		1: '等待提供方确认'
		2: '等待用户付款'
		3: '可以实验'
		4: '正在实验'
		5: '等待用户确认'
		0: '已取消'
	(value)->
		return name[value]

providerFilter.filter 'classFilter', ->
	name =
		1: 'btn btn-success'
		2: 'btn btn-default disabled'
		3: 'btn btn-default disabled'
		4: 'btn btn-success'
		5: 'btn btn-default disabled'
		0: 'btn btn-default disabled'
	(value)->
		return name[value]

providerFilter.filter 'buttonTextFilter', ->
	name =
		1: '确认'
		2: '等待'
		3: '等待'
		4: '完成实验'
		5: '等待'
		0: '已取消'
	(value)->
		return name[value]

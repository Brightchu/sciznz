'use strict'

supplyFilter = angular.module('supplyFilter', [])
supplyFilter.filter 'statusFilter', ->
	name =
		1: '等待提供方确认'
		2: '等待用户付款'
		3: '准备就绪'
		4: '正在实验'
		5: '等待用户确认'
		6: '已完成'
		0: '已取消'
	(value)->
		return name[value]

supplyFilter.filter 'classFilter', ->
	name =
		1: 'btn btn-success'
		2: 'btn btn-default disabled'
		3: 'btn btn-success'
		4: 'btn btn-success'
		5: 'btn btn-default disabled'
		6: 'btn btn-default disabled'
		0: 'btn btn-default disabled'
	(value)->
		return name[value]

supplyFilter.filter 'buttonTextFilter', ->
	name =
		1: '确认'
		2: '等待'
		3: '开始实验'
		4: '完成实验'
		5: '等待'
		6: '已完成'
		0: '已取消'
	(value)->
		return name[value]

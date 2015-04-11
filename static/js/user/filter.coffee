'use strict'

userFilter = angular.module('userFilter', [])
userFilter.filter 'statusFilter', ->
	name =
		1: '等待提供方确认'
		2: '等待用户付款'
		3: '已付款，准备实验'
		4: '正在实验'
		5: '等待用户确认'
		6: '已完成'
		0: '已取消'
	(value)->
		name[value]

userFilter.filter 'classFilter', ->
	name =
		1: 'btn btn-default disabled'
		2: 'btn btn-success'
		3: 'btn btn-default disabled'
		4: 'btn btn-default disabled'
		5: 'btn btn-success'
		6: 'btn btn-default disabled'
		0: 'btn btn-default disabled'
	(value)->
		return name[value]

userFilter.filter 'buttonTextFilter', ->
	name =
		1: '等待'
		2: '立即付款'
		3: '等待'
		4: '等待'
		5: '确认完成'
		6: '已完成'
		0: '已取消'
	(value)->
		return name[value]

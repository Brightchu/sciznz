'use strict'

helperFilter = angular.module('helperFilter', [])
helperFilter.filter 'statusFilter', ->
	name =
		NEW: '等待提供方确认'
		CONFIRM: '已确认，待付款'
		BUDGET: '已付款，等候实验'
		BEGIN: '正在实验'
		END: '待支付实验费用'
		DONE: '已完成'
		CANCEL: '已取消'
	(status)->
		return name[status]

helperFilter.filter 'actionClassFilter', ->
	name =
		NEW: 'btn btn-success'
		CONFIRM: 'hidden'
		BUDGET: 'btn btn-success'
		BEGIN: 'btn btn-success'
		END: 'hidden'
		DONE: 'hidden'
		CANCEL: 'hidden'
	(status)->
		return name[status]

helperFilter.filter 'actionTextFilter', ->
	name =
		NEW: '确认'
		BUDGET: '开始实验'
		BEGIN: '结束实验'
	(status)->
		return name[status]

helperFilter.filter 'cancelFilter', ->
	(status)->
		if status == 'CANCEL' || status == 'DONE'
			return false
		else
			return true

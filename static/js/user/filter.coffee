'use strict'

userFilter = angular.module('userFilter', [])
userFilter.filter 'statusFilter', ->
	name =
		NEW: '等待提供方确认'
		CONFIRM: '已确认，待付款'
		BUDGET: '已付款，等候实验'
		BEGIN: '正在实验'
		END: '实验完成，待支付差价'
		DONE: '已完成'
		CANCEL: '已取消'
	(status)->
		name[status]

userFilter.filter 'actionClassFilter', ->
	name =
		NEW: 'hidden'
		CONFIRM: 'btn btn-success'
		BUDGET: 'hidden'
		BEGIN: 'hidden'
		END: 'btn btn-success'
		DONE: 'hidden'
		CANCEL: 'hidden'
	(status)->
		return name[status]

userFilter.filter 'actionTextFilter', ->
	name =
		CONFIRM: '立即支付'
		END: '立即支付'
	(status)->
		return name[status]

userFilter.filter 'cancelFilter', ->
	(status)->
		if status == 'CANCEL' || status == 'DONE'
			return false
		else
			return true

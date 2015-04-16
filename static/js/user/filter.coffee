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
	(value)->
		name[value]

userFilter.filter 'buttonClassFilter', ->
	name =
		NEW: 'hidden'
		CONFIRM: 'btn btn-success'
		BUDGET: 'hidden'
		BEGIN: 'hidden'
		END: 'btn btn-success'
		DONE: 'hidden'
		CANCEL: 'hidden'
	(value)->
		return name[value]

userFilter.filter 'buttonTextFilter', ->
	name =
		CONFIRM: '立即支付'
		END: '立即支付'
	(value)->
		return name[value]

userFilter.filter 'cancelFilter', ->
	(status)->
		return true

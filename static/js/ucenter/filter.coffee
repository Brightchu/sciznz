'use strict'

ucenterFilter = angular.module('ucenterFilter', [])
ucenterFilter.filter 'statusFilter', ->
	name =
		1: '等待提供方确认'
	(value)->
		return name[value]

ucenterFilter.filter 'classFilter', ->
	name =
		1: 'btn btn-default disabled'
	(value)->
		return name[value]

ucenterFilter.filter 'buttonClickFilter', ->
	name =
		1: 'update()'
	(value)->
		return name[value]

ucenterFilter.filter 'buttonTextFilter', ->
	name =
		1: '请等待'
	(value)->
		return name[value]


'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
supplyApp = angular.module('supplyApp', ['ngRoute', 'ngAnimate', 'pascalprecht.translate', 'supplyCtrl', 'supplyService', 'supplyFilter'])
supplyApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/order-active'
		templateUrl: '/static/partial/supply/order-active.html'
		controller: 'orderActiveCtrl'
	).when('/order-done'
		templateUrl: '/static/partial/supply/order-done.html'
		controller: 'orderDoneCtrl'
	).when('/device-timetable'
		templateUrl: '/static/partial/admin/generic-blank.html'
		controller: 'deviceTimetableCtrl'
	).otherwise(
		redirectTo: '/order-active'
	)
])

supplyApp.config(['$compileProvider', ($compileProvider)->
	$compileProvider.debugInfoEnabled(false)
])

supplyApp.config(['$translateProvider', ($translateProvider)->
	$translateProvider.translations 'zh',
		'confirmCancel': '确认取消订单？'
		'orderCanceled': '订单已成功取消'
		'orderCancelFail': '取消订单失败，请与我们联系'
		'budget': '支付预算'
		'fill': '支付差价'
		'confirmConfirm': '确认同意实验？'
		'confirmed': '已同意实验'
		'confirmFailed': '同意实验失败，请与我们联系'
		'confirmBegin': '确认开始实验？'
		'begined': '已开始实验'
		'beginFailed': '开始实验失败，请与我们联系'

	$translateProvider.preferredLanguage('zh')

])

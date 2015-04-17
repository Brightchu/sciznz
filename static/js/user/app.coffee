'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
userApp = angular.module('userApp', ['ngRoute', 'ngAnimate', 'pascalprecht.translate', 'userCtrl', 'userService', 'userFilter'])
userApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/order-active'
		templateUrl: '/static/partial/user/order-active.html'
		controller: 'orderActiveCtrl'
	).when('/order-done'
		templateUrl: '/static/partial/user/order-done.html'
		controller: 'orderDoneCtrl'
	).when('/personal-info'
		templateUrl: '/static/partial/user/personal-info.html'
		controller: 'personalInfoCtrl'
	).otherwise(
		redirectTo: '/order-active'
	)
])

userApp.config(['$compileProvider', ($compileProvider)->
	$compileProvider.debugInfoEnabled(false)
])

userApp.config(['$translateProvider', ($translateProvider)->
	$translateProvider.translations 'zh',
		'confirmCancel': '确认取消订单？'
		'orderCanceled': '订单已成功取消'
		'orderCancelFail': '取消订单失败，请与我们联系'
		'budget': '支付预算'
		'fill': '支付差价'
		'budgetPayed': '支付预算成功'
		'budgetPayFail': '支付预算失败，请与我们联系'
		'fillPayed': '支付预算成功'
		'fillPayFail': '支付预算失败，请与我们联系'

	$translateProvider.preferredLanguage('zh')

])

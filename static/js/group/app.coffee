'use strict'

# syntactic sugar
window.$ = angular.element
window.$.prototype.click = ->
	clickEvent = document.createEvent('MouseEvent')
	clickEvent.initEvent('click', true, true)
	for element in this
		element.dispatchEvent(clickEvent)

# glue modules
groupApp = angular.module('groupApp', ['ngRoute', 'ngAnimate', 'pascalprecht.translate', 'groupCtrl', 'groupService', 'groupFilter'])
groupApp.config(['$routeProvider', ($routeProvider)->
	$routeProvider.when('/member'
		templateUrl: '/static/partial/group/member.html'
		controller: 'memberCtrl'
	).when('/bill'
		templateUrl: '/static/partial/group/bill.html'
		controller: 'billCtrl'
	).when('/info'
		templateUrl: '/static/partial/group/info.html'
		controller: 'infoCtrl'
	).otherwise(
		redirectTo: '/member'
	)
])

groupApp.config(['$compileProvider', ($compileProvider)->
	$compileProvider.debugInfoEnabled(false)
])

groupApp.config(['$translateProvider', ($translateProvider)->
	$translateProvider.translations 'zh',
		'confirmAdd': '确认添加？'
		'addSucess': '添加成功'
		'addFail': '添加失败'
		'confirmDelete': '确认删除？'
		'deleteSucess': '删除成功'
		'deleteFail': '删除失败'

	$translateProvider.preferredLanguage('zh')

])

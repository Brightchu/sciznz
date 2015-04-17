'use strict'

helperCtrl = angular.module('helperCtrl', ['ngCookies', 'ui.bootstrap'])

helperCtrl.controller 'topCtrl', ['$scope', 'Helper', ($scope, Helper)->
	$scope.info = Helper.info()
]

helperCtrl.controller 'accordionCtrl', ['$scope', '$location', '$cookies', ($scope, $location, $cookies)->
	$(document).ready ->
		heading = $(document.querySelectorAll('.panel-heading'))
		heading.on 'click', ->
			heading.removeClass('open')
			$(this).addClass('open')

		entry = $(document.querySelectorAll('.panel-group p'))
		entry.on 'click', ->
			entry.removeClass('active')
			$(this).addClass('active')

		link = $(document.querySelector("[href='##{$location.path()}']"))
		link.parent().click()
		$($(link.parent().parent().parent().parent().children()[0]).children()[0]).children().click()

	$scope.logout = ->
		if confirm('退出当前账号？')
			for key, value of $cookies
				delete $cookies[key]
			window.location = '/helper/login'
]

helperCtrl.controller 'orderActiveCtrl', ['$scope', '$modal', '$filter', 'Order', ($scope, $modal, $filter, Order)->
	$scope.orderList = Order.helperActive()

	$scope.action = ->
		self = this
		switch this.order.status
			when 'NEW'
				if confirm($filter('translate')('confirmConfirm'))
					payload =
						orderID: self.order.ID
					Order.confirm(payload).$promise.then ->
						alert($filter('translate')('confirmed'))
						self.order.status = 'CONFIRM'
					, ->
						alert($filter('translate')('confirmFailed'))

			when 'BUDGET'
				if confirm($filter('translate')('confirmBegin'))
					payload =
						orderID: self.order.ID
					Order.begin(payload).$promise.then ->
						alert($filter('translate')('begined'))
						self.order.status = 'BEGIN'
					, ->
						alert($filter('translate')('beginFailed'))
			when 'BEGIN'
				$modal.open
					templateUrl: '/static/partial/helper/detail.html'
					controller: 'detailCtrl'
					size: 'sm'
					resolve:
						order: ->
							return self.order

	$scope.cancel = ->
		if confirm($filter('translate')('confirmCancel'))
			self = this
			payload =
				orderID: self.order.ID
			Order.cancel(payload).$promise.then ->
				alert($filter('translate')('orderCanceled'))
				self.order.status = 'CANCEL'
			, ->
				alert($filter('translate')('orderCancelFail'))
]

helperCtrl.controller 'orderDoneCtrl', ['$scope', 'Order', ($scope, Order)->
	$scope.orderList = Order.helperDone()
]

helperCtrl.controller 'detailCtrl', ['$scope', '$modalInstance', '$timeout', '$filter', 'order', 'Order', ($scope, $modalInstance, $timeout, $filter, order, Order)->
	$scope.end = ->
		if confirm($filter('translate')('confirmEnd'))
			payload =
				orderID: order.ID
				fill: $scope.fill
				detail: $scope.detail

			Order.end(payload).$promise.then ->
				alert($filter('translate')('ended'))
				order.status = 'END'
				$modalInstance.close()
			, ->
				alert($filter('translate')('endFailed'))
]

helperCtrl.controller 'helperInfoCtrl', ['$scope', 'Helper', ($scope, Helper)->
	$scope.info = Helper.info()
	$scope.password = {}

	$scope.updateInfo = ->
		Helper.updateInfo($scope.info).$promise.then ->
			alert('更新信息成功')
		, ->
			alert('更新信息失败')

	$scope.updatePassword = ->
		if $scope.password.newPassword?
			if $scope.password.newPassword == $scope.password.newPasswordAgain
				Helper.updatePassword($scope.password).$promise.then ->
					alert('修改密码成功')
				, ->
					alert('修改密码失败')
			else
				alert('两次输入的新密码不一致')
		else
			alert('请输入密码')
]

helperCtrl.controller 'deviceTimetableCtrl', ['$scope', ($scope)->
	$scope.title = '仪器日历'
]

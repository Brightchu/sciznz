'use strict'

supplyCtrl = angular.module('supplyCtrl', ['ui.bootstrap'])
supplyCtrl.controller 'accordionCtrl', ['$scope', '$location', ($scope, $location)->
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
]

openModel = ($modal, $scope, type, order)->
	modalInstance = $modal.open
		templateUrl: '/static/partial/user/pay.html'
		controller: 'payCtrl'
		size: 'sm'
		resolve:
			type: ->
				return type
			order: ->
				return order

supplyCtrl.controller 'orderActiveCtrl', ['$scope', '$modal', '$filter', 'Order', ($scope, $modal, $filter, Order)->
	$scope.orderList = Order.supplyActive()

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
					Order.confirm(payload).$promise.then ->
						alert($filter('translate')('begined'))
						self.order.status = 'BEGIN'
					, ->
						alert($filter('translate')('beginFailed'))

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

supplyCtrl.controller 'orderDoneCtrl', ['$scope', 'Order', ($scope, Order)->
	$scope.orderList = Order.userDone()
]

supplyCtrl.controller 'payCtrl', ['$scope', '$modalInstance', '$timeout', '$filter', 'type', 'order', 'User', 'Order', ($scope, $modalInstance, $timeout, $filter, type, order, User, Order)->
	$scope.title = $filter('translate')(type)
	$scope.order = order
	$scope.amount = order[type]
	$scope.methodList = User.payMethod()
	$scope.payMethod = {}

	$scope.pay = ->
		if $scope.payMethod.groupID
			payload =
				orderID: order.ID
				method: 'GROUP'
				account: $scope.payMethod.groupID
			
			if type == 'budget'
				Order.budget(payload).$promise.then ->
					alert($filter('translate')('budgetPayed'))
					order.status = 'BUDGET'
					$modalInstance.close()
				, ->
					alert($filter('translate')('budgetPayFail'))
			else
				Order.budget(payload).$promise.then ->
					alert($filter('translate')('fillPayed'))
					order.status = 'DONE'
					$modalInstance.close()
				, ->
					alert($filter('translate')('fillPayFail'))
		else
			alert('请选择支付方式')
]

supplyCtrl.controller 'personalInfoCtrl', ['$scope', 'User', ($scope, User)->
	$scope.info = User.info()
	User.payMethod().$promise.then (response)->
		list = response.map (method)->
			method.groupName
		if list.length
			$scope.method = list.join(' ')

	$scope.password = {}

	$scope.updateInfo = ->
		User.updateInfo($scope.info).$promise.then ->
			alert('更新信息成功')
		, ->
			alert('更新信息失败')

	$scope.updatePassword = ->
		if $scope.password.newPassword?
			if $scope.password.newPassword == $scope.password.newPasswordAgain
				User.updatePassword($scope.password).$promise.then ->
					alert('修改密码成功')
				, ->
					alert('修改密码失败')
			else
				alert('两次输入的新密码不一致')
		else
			alert('请输入密码')
]

supplyCtrl.controller 'deviceTimetableCtrl', ['$scope', ($scope)->
	$scope.title = '仪器日历'
]

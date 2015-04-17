'use strict'

userCtrl = angular.module('userCtrl', ['ngCookies', 'ui.bootstrap'])

userCtrl.controller 'accordionCtrl', ['$scope', '$location', '$cookies', ($scope, $location, $cookies)->
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
			window.location = '/'
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

userCtrl.controller 'orderActiveCtrl', ['$scope', '$modal', '$filter', 'Order', ($scope, $modal, $filter, Order)->
	$scope.orderList = Order.userActive()

	$scope.action = ->
		if this.order.status == 'CONFIRM'
			openModel($modal, $scope, 'budget', this.order)
		else
			openModel($modal, $scope, 'fill', this.order)

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

userCtrl.controller 'orderDoneCtrl', ['$scope', 'Order', ($scope, Order)->
	$scope.orderList = Order.userDone()
]

userCtrl.controller 'payCtrl', ['$scope', '$modalInstance', '$timeout', '$filter', 'type', 'order', 'User', 'Order', ($scope, $modalInstance, $timeout, $filter, type, order, User, Order)->
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

userCtrl.controller 'personalInfoCtrl', ['$scope', 'User', ($scope, User)->
	$scope.info = User.get()
	$scope.password = {}

	$scope.updateInfo = ->
		User.update($scope.info).$promise.then ->
			alert('更新信息成功')
		, ->
			alert('更新信息失败')

	$scope.updatePassword = ->
		if $scope.password.newPassword?
			if $scope.password.newPassword == $scope.password.newPasswordAgain
				User.save($scope.password).$promise.then ->
					alert('修改密码成功')
				, ->
					alert('修改密码失败')
			else
				alert('两次输入的新密码不一致')
		else
			alert('请输入密码')
]

'use strict'

providerCtrl = angular.module('providerCtrl', ['ui.bootstrap'])
providerCtrl.controller 'accordionCtrl', ['$scope', '$location', ($scope, $location)->
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

providerCtrl.controller 'messageNewCtrl', ['$scope', 'Order', ($scope, Order)->
	$scope.orderList = Order.query()

	$scope.upgrade = ->
		self = this

		payload =
			status: self.order.status + 1
			ID: self.order.ID
		
		Order.update(payload).$promise.then ->
			alert('操作成功')
			self.order.status += 1
		, ->
			alert('操作失败')

	$scope.cancel = ->
		self = this

		payload =
			status: 0
			ID: self.order.ID
		
		Order.update(payload).$promise.then ->
			alert('操作成功')
			self.order.status = 0
		, ->
			alert('操作失败')
]

providerCtrl.controller 'deviceTimetableCtrl', ['$scope', ($scope)->

]

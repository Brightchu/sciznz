'use strict'

groupCtrl = angular.module('groupCtrl', ['ngCookies', 'ui.bootstrap'])

groupCtrl.controller 'accordionCtrl', ['$scope', '$location', '$cookies', ($scope, $location, $cookies)->
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

groupCtrl.controller 'personalInfoCtrl', ['$scope', 'Info', ($scope, Info)->
	$scope.info = Info.get()
	$scope.password = {}

	$scope.updateInfo = ->
		Info.update($scope.info).$promise.then ->
			alert('更新信息成功')
		, ->
			alert('更新信息失败')

	$scope.updatePassword = ->
		if $scope.password.newPassword?
			if $scope.password.newPassword == $scope.password.newPasswordAgain
				Info.save($scope.password).$promise.then ->
					alert('修改密码成功')
				, ->
					alert('修改密码失败')
			else
				alert('两次输入的新密码不一致')
		else
			alert('请输入密码')
]

groupCtrl.controller 'memberAdminCtrl', ['$scope', 'Member', ($scope, Member)->
	$scope.memberList = Member.query()

	$scope.delete = ->
		self = this

		payload =
			ID: self.member.ID
		
		Member.delete(payload).$promise.then ->
			alert('操作成功')
		, ->
			alert('操作失败')

	$scope.add = ->
		console.log('HERE')
		self = this

		payload =
			email: $scope.newMember
		
		Member.save(payload).$promise.then ->
			alert('操作成功')
		, ->
			alert('操作失败')
]

groupCtrl.controller 'billInfoCtrl', ['$scope', 'Bill', ($scope, Bill)->
	$scope.billList = Bill.query()

]

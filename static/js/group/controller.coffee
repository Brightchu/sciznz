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

groupCtrl.controller 'memberCtrl', ['$scope', '$filter', 'Member', ($scope, $filter, Member)->
	$scope.memberList = Member.query()

	$scope.delete = ->
		self = this
		payload =
			userID: self.member.userID

		if confirm($filter('translate')('confirmDelete') + self.member.email)
			Member.delete(payload).$promise.then ->
				alert('删除成功')
				$scope.memberList = $scope.memberList.filter (member)->
					return member.userID != self.member.userID
			, ->
				alert('删除失败')

	$scope.add = ->
		self = this
		payload =
			email: $scope.newEmail

		if confirm($filter('translate')('confirmAdd') + $scope.newEmail)
			Member.save(payload).$promise.then ->
				alert($filter('translate')('addSucess'))
				$scope.memberList = Member.query()
			, ->
				alert($filter('translate')('addFail'))
]

groupCtrl.controller 'billCtrl', ['$scope', 'Bill', ($scope, Bill)->
	$scope.billList = Bill.query()

]

groupCtrl.controller 'infoCtrl', ['$scope', 'Group', ($scope, Group)->
	$scope.info = Group.info()
	$scope.password = {}

	$scope.updateInfo = ->
		Group.updateInfo($scope.info).$promise.then ->
			alert('更新信息成功')
		, ->
			alert('更新信息失败')

	$scope.updatePassword = ->
		if $scope.password.newPassword?
			if $scope.password.newPassword == $scope.password.newPasswordAgain
				Group.updatePassword($scope.password).$promise.then ->
					alert('修改密码成功')
				, ->
					alert('修改密码失败')
			else
				alert('两次输入的新密码不一致')
		else
			alert('请输入密码')
]

#!/bin/bash
coffee --join static/js/admin.js --watch --compile static/js/admin/app.coffee static/js/admin/controller.coffee static/js/admin/service.coffee&
coffee --join static/js/front.js --watch --compile static/js/front/app.coffee static/js/front/controller.coffee static/js/front/service.coffee static/js/front/filter.coffee&
coffee --join static/js/ucenter.js --watch --compile static/js/ucenter/app.coffee static/js/ucenter/controller.coffee static/js/ucenter/service.coffee static/js/ucenter/filter.coffee&
coffee --join static/js/supply.js --watch --compile static/js/supply/app.coffee static/js/supply/controller.coffee static/js/supply/service.coffee static/js/supply/filter.coffee&
coffee --join static/js/group.js --watch --compile static/js/group/app.coffee static/js/group/controller.coffee static/js/group/service.coffee static/js/group/filter.coffee&

jade -w -P application/views/*.jade&
jade -w -P application/views/mail/*.jade&
jade -w -P static/partial/front/*.jade&
jade -w -P static/partial/admin/*.jade&
jade -w -P static/partial/ucenter/*.jade&
jade -w -P static/partial/supply/*.jade&
jade -w -P static/partial/group/*.jade&

echo "The development environment has ready!"

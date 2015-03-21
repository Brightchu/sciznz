#!/bin/bash
coffee --join static/js/admin.js --watch --compile static/js/admin/app.coffee static/js/admin/controller.coffee static/js/admin/service.coffee&
coffee --join static/js/script.js --watch --compile static/js/app.coffee static/js/controller.coffee static/js/service.coffee static/js/filter.coffee&
coffee --join static/js/ucenter.js --watch --compile static/js/ucenter/app.coffee static/js/ucenter/controller.coffee static/js/ucenter/service.coffee&

jade -w -P application/views/*.jade&
jade -w -P application/views/mail/*.jade&
jade -w -P static/partial/*.jade&
jade -w -P static/partial/admin/*.jade&
jade -w -P static/partial/ucenter/*.jade&

echo "The development environment has ready!"

#!/bin/bash
coffee --join static/js/admin.js --watch --compile static/js/admin/app.coffee static/js/admin/controller.coffee static/js/admin/service.coffee&
coffee --join static/js/script.js --watch --compile static/js/app.coffee static/js/controller.coffee static/js/service.coffee&

jade -w -P application/views/*.jade&
jade -w -P static/partial/*.jade&
jade -w -P static/partial/admin/*.jade&

echo "The development environment has ready!"

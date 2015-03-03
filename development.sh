#!/bin/bash
coffee --join static/js/admin.js --watch --compile static/js/admin/app.coffee static/js/admin/controller.coffee static/js/admin/service.coffee&

jade -w -P application/views/*.jade&
jade -w -P static/partial/admin/*.jade&

echo "The development environment has ready!"

#!/bin/bash
coffee --join static/js/supervisor.js --watch --compile static/js/supervisor/app.coffee static/js/supervisor/controller.coffee static/js/supervisor/service.coffee&

jade -w -P application/views/*.jade&
jade -w -P static/partial/supervisor/*.jade&

echo "The development environment has ready!"

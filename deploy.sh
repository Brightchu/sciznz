#!/bin/bash
# compile
coffee --join static/js/supervisor.js --compile static/js/supervisor/app.coffee static/js/supervisor/controller.coffee static/js/supervisor/service.coffee
lessc -x static/css/style.less static/css/style.css
lessc -x static/css/supervisor/style.less static/css/supervisor/style.css
jade application/views/*.jade
jade static/partial/supervisor/*.jade

# compress
uglifyjs static/js/supervisor.js --mangle --compress --screw-ie8 -o static/js/supervisor.js

echo "The files are ready to deploy."

#!/bin/bash
# compile
coffee --join static/js/admin.js --compile static/js/admin/app.coffee static/js/admin/controller.coffee static/js/admin/service.coffee
lessc -x static/css/style.less static/css/style.css
lessc -x static/css/login.less static/css/login.css
lessc -x static/css/admin.less static/css/admin.css
jade application/views/*.jade
jade static/partial/admin/*.jade

# compress
uglifyjs static/js/admin.js --mangle --compress --screw-ie8 -o static/js/admin.js

echo "The files are ready to deploy."

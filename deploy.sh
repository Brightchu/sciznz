#!/bin/bash
# compile
coffee --compile static/js/*.coffee
coffee --compile static/js/supervisor/*.coffee
lessc -x static/css/style.less static/css/style.css
lessc -x static/css/supervisor/style.less static/css/supervisor/style.css
jade application/views/*.jade
jade static/partial/supervisor/*.jade

# compress
#uglifyjs static/js/script.js --mangle --compress --screw-ie8 -o static/js/script.js
#uglifyjs static/js/supervisor/controller.js --mangle --compress --screw-ie8 -o static/js/supervisor/controller.js

echo "The files are ready to deploy."

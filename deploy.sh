#!/bin/bash
# copy files
rm -rf /tmp/sciclubs/
cp . -r /tmp/sciclubs/
cd /tmp/sciclubs/

# compile
coffee --join static/js/admin.js --compile static/js/admin/app.coffee static/js/admin/controller.coffee static/js/admin/service.coffee
coffee --join static/js/front.js --compile static/js/front/app.coffee static/js/front/controller.coffee static/js/front/service.coffee static/js/front/filter.coffee
coffee --join static/js/ucenter.js --compile static/js/ucenter/app.coffee static/js/ucenter/controller.coffee static/js/ucenter/service.coffee static/js/ucenter/filter.coffee
coffee --join static/js/supply.js --compile static/js/supply/app.coffee static/js/supply/controller.coffee static/js/supply/service.coffee static/js/supply/filter.coffee
coffee --join static/js/group.js --compile static/js/group/app.coffee static/js/group/controller.coffee static/js/group/service.coffee static/js/group/filter.coffee

lessc -x static/css/style.less static/css/style.css
lessc -x static/css/login.less static/css/login.css
lessc -x static/css/admin.less static/css/admin.css
lessc -x static/css/ucenter.less static/css/ucenter.css
lessc -x static/css/supply.less static/css/supply.css
lessc -x static/css/group.less static/css/group.css

jade application/views/*.jade
jade application/views/mail/*.jade&
jade static/partial/front/*.jade
jade static/partial/admin/*.jade
jade static/partial/ucenter/*.jade
jade static/partial/supply/*.jade
jade static/partial/group/*.jade

# compress
uglifyjs static/js/admin.js --mangle --compress --screw-ie8 -o static/js/admin.js
uglifyjs static/js/front.js --mangle --compress --screw-ie8 -o static/js/front.js
uglifyjs static/js/ucenter.js --mangle --compress --screw-ie8 -o static/js/ucenter.js
uglifyjs static/js/supply.js --mangle --compress --screw-ie8 -o static/js/supply.js
uglifyjs static/js/group.js --mangle --compress --screw-ie8 -o static/js/group.js

# clean up
rm -rf doc
find . -name "*.coffee" -exec rm -fv {} \;
find . -name "*.less" -exec rm -fv {} \;
find . -name "*.jade" -exec rm -fv {} \;
find . -name "*.md" -exec rm -fv {} \;
find . -name "*.json" -exec rm -fv {} \;
find . -name "*.sh" -exec rm -fv {} \;

#deploy
saecloud deploy

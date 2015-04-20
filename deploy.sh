#!/bin/bash
# copy files
rm -rf /tmp/sciclubs/
cp . -r /tmp/sciclubs/
cd /tmp/sciclubs/

# compile
coffee --join static/js/admin.js --compile static/js/admin/app.coffee static/js/admin/controller.coffee static/js/admin/service.coffee
coffee --join static/js/front.js --compile static/js/front/app.coffee static/js/front/controller.coffee static/js/front/service.coffee static/js/front/filter.coffee
coffee --join static/js/user.js --compile static/js/user/app.coffee static/js/user/controller.coffee static/js/user/service.coffee static/js/user/filter.coffee
coffee --join static/js/supply.js --compile static/js/supply/app.coffee static/js/supply/controller.coffee static/js/supply/service.coffee static/js/supply/filter.coffee
coffee --join static/js/helper.js --compile static/js/helper/app.coffee static/js/helper/controller.coffee static/js/helper/service.coffee static/js/helper/filter.coffee
coffee --join static/js/group.js --compile static/js/group/app.coffee static/js/group/controller.coffee static/js/group/service.coffee static/js/group/filter.coffee

lessc -x static/css/theme.less static/css/theme.css
lessc -x static/css/front.less static/css/front.css
lessc -x static/css/login.less static/css/login.css
lessc -x static/css/panel.less static/css/panel.css

jade application/views/*.jade
jade application/views/mail/register/*.jade
jade application/views/mail/order/user/*.jade
jade application/views/mail/order/supply/*.jade
jade static/partial/front/*.jade
jade static/partial/admin/*.jade
jade static/partial/user/*.jade
jade static/partial/supply/*.jade
jade static/partial/helper/*.jade
jade static/partial/group/*.jade

# compress
uglifyjs static/js/admin.js --mangle --compress --screw-ie8 -o static/js/admin.js
uglifyjs static/js/front.js --mangle --compress --screw-ie8 -o static/js/front.js
uglifyjs static/js/user.js --mangle --compress --screw-ie8 -o static/js/user.js
uglifyjs static/js/supply.js --mangle --compress --screw-ie8 -o static/js/supply.js
uglifyjs static/js/helper.js --mangle --compress --screw-ie8 -o static/js/helper.js
uglifyjs static/js/group.js --mangle --compress --screw-ie8 -o static/js/group.js

# clean up
rm -rf doc
rm -rf upload
find . -name "*.coffee" -exec rm -fv {} \;
find . -name "*.less" -exec rm -fv {} \;
find . -name "*.jade" -exec rm -fv {} \;
find . -name "*.md" -exec rm -fv {} \;
find . -name "*.json" -exec rm -fv {} \;
find . -name "*.sh" -exec rm -fv {} \;

#deploy
saecloud deploy

Patch and Config for CodeIgniter on SAE
===

1. Set up URL Rewrite
---
1. Edit application/config/config.php
```
$config['index_page'] = '';
```
2. Add rewrite handle in config.yaml
```
handle:
- rewrite: if (!-d && !-f) goto "/index.php/%{QUERY_STRING}"
```
3. Deny privacy folder access in config.yaml
```
handle:
- rewrite: if (%{REQUEST_URI} ~ "/application") goto "/index.php/%{QUERY_STRING}"
- rewrite: if (%{REQUEST_URI} ~ "/system") goto "/index.php/%{QUERY_STRING}"
- rewrite: if (%{REQUEST_URI} ~ "/doc") goto "/index.php/%{QUERY_STRING}"
```

2. Set up Database
---
1. Use `defined('SAE_APPNAME')` to detect environment
2. Config `$db['default']` and `$db['slave']` to Master / Slave database

3. Adapt Log class
---
1. Edit application/config/config.php (assume no MY_*.php in the directory)
```
$config['subclass_prefix'] = defined('SAE_APPNAME') ? 'SAE_' : 'MY_';
```
2. Extend Log.php to SAE_Log.php

4. Create Kvdb class
---
1. Extend class `SaeKV` on SAE environment
2. Extend class `Redis` for others

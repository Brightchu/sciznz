Patch and Config for CodeIgniter on SAE
======

1. Set up URL Rewrite
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
	- rewrite: if(%{REQUEST_URI} ~ "/application" || %{REQUEST_URI} ~ "/system" || %{REQUEST_URI} ~ "/doc") goto "/index.php/%{QUERY_STRING}"
	```

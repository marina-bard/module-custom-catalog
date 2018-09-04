CustomCatalog module
===

This module adds a "CustomCatalog" menu on CATALOG section. It allows to execute CRUD actions with custom products.  

Intallation via Composer:
```bash
composer config repositories.module-custom-catalog vcs https://github.com/marina-bard/module-custom-catalog.git
composer require magento/module-custom-catalog dev-master
```

The module exposes API-methods:
```php
GET http://magento2.local/rest/default/V1/product/getByVPN/{vpn}
PUT http://magento2.local/rest/default/V1/product/update
```
JSON-data sample can be found in data.json.sample in project root directory.
  
The following command runs rabbitmq consumer:  
```php
bin/magento customcatalog:cosumer
``` 

Enjoy!

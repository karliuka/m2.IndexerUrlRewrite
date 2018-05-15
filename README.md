# Magento2 Indexer UrlRewrite 
Extension rebuild UrlRewrite index.

## Install with Composer as you go

1. Go to Magento 2 root folder

2. Enter following commands to install module:

    ```bash
    composer require faonni/module-indexer-url-rewrite
    ```
   Wait while dependencies are updated.

3. Enter following commands to enable module:

    ```bash
	php bin/magento setup:upgrade
	php bin/magento setup:static-content:deploy
    ```
    	
3. Command options:	
    ```bash	
	php bin/magento indexer:reindex category_url_rewrite
	php bin/magento indexer:reindex product_url_rewrite
	php bin/magento indexer:reindex cms_page_url_rewrite
    ```

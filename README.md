# Magento2 Indexer UrlRewrite
[![Total Downloads](https://poser.pugx.org/faonni/module-indexer-url-rewrite/downloads)](https://packagist.org/packages/faonni/module-indexer-url-rewrite)
[![Latest Stable Version](https://poser.pugx.org/faonni/module-indexer-url-rewrite/v/stable)](https://packagist.org/packages/faonni/module-indexer-url-rewrite)

Extension rebuild UrlRewrite index.

## Compatibility

Magento CE (EE) 2.0.x, 2.1.x, 2.2.x, 2.3.x, 2.4.x

## Install

#### Install via Composer (recommend)
The corresponding version of the Smart Category Kit will be installed automatically.

1. Go to Magento2 root folder

2. Enter following commands to install module:

     For Magento CE (EE) 2.0.x, 2.1.x, 2.2.x

    ```bash
    composer require faonni/module-indexer-url-rewrite:2.0.*
    ```

     For Magento CE (EE) 2.3.x

    ```bash
    composer require faonni/module-indexer-url-rewrite:2.3.*
    ```

     For Magento CE (EE) 2.4.x

    ```bash
    composer require faonni/module-indexer-url-rewrite:2.4.*
    ```

   Wait while dependencies are updated.

#### Manual Installation

1. Create a folder {Magento root}/app/code/Faonni/IndexerUrlRewrite

2. Download the corresponding [latest version](https://github.com/karliuka/m2.IndexerUrlRewrite/releases)

3. Copy the unzip content to the folder ({Magento root}/app/code/Faonni/IndexerUrlRewrite)

#### Completion of installation

1. Go to Magento2 root folder

2. Enter following commands:

    ```bash
    php bin/magento setup:upgrade
    php bin/magento setup:di:compile
    php bin/magento setup:static-content:deploy (optional)
    ```
## Using

1. Go to Magento2 root folder

2. Enter following commands:

    ```bash
    php bin/magento indexer:reindex
    ```
    or (depending on need)

    ```bash
    php bin/magento indexer:reindex category_url_rewrite
    php bin/magento indexer:reindex product_url_rewrite
    php bin/magento indexer:reindex cms_page_url_rewrite
    ```

## Uninstall
This works only with modules defined as Composer packages.

#### Remove Extension

1. Go to Magento2 root folder

2. Enter following commands to remove:

    ```bash
    composer remove faonni/module-indexer-url-rewrite
    ```

#### Completion of uninstall

1. Go to Magento2 root folder

2. Enter following commands:

    ```bash
    php bin/magento setup:upgrade
    php bin/magento setup:di:compile
    php bin/magento setup:static-content:deploy (optional)
    ```

<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\UrlRewrite\Model\UrlPersistInterface;

use Magento\Store\Model\StoreManagerInterface;

/**
 * IndexerUrlRewrite product indexer model
 */
class ProductIndexer extends AbstractIndexer
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected $_productCollection;
    
    /**
     * @var \Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator
     */
    protected $_productUrlRewriteGenerator;

    protected $_storeManager;
    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     * @param \Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator $productUrlRewriteGenerator
     * @param \Magento\UrlRewrite\Model\UrlPersistInterface $urlPersist
     */
    public function __construct(
        ProductCollection $productCollection,
        ProductUrlRewriteGenerator $productUrlRewriteGenerator,      
        UrlPersistInterface $urlPersist,
        StoreManagerInterface $storeManager
    ) {
        $this->_productCollection = $productCollection;
        $this->_productUrlRewriteGenerator = $productUrlRewriteGenerator;
        $this->_storeManager  = $storeManager;
        parent::__construct($urlPersist);
    }
    	
    /**
     * Retrieve entity collection
     *
     * @param integer $storeId
     * @return object
     */
	protected function getEntityCollection($storeId)
	{
		$this->_productCollection->clear();
		$this->_productCollection->setStoreId($storeId)
			->addAttributeToSelect(['url_path', 'url_key']);
			
		return $this->_productCollection;
	}
    
    /**
     * Retrieve entity type
     *
     * @return string
     */
	protected function getEntityType()
	{
		return ProductUrlRewriteGenerator::ENTITY_TYPE;	
	}
    
    /**
     * Retrieve entity rewrite generator
     *
     * @return object
     */
	protected function getRewriteGenerator()
	{
		return $this->_productUrlRewriteGenerator;
	}
}

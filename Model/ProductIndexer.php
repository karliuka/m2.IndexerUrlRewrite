<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\UrlPersistInterface;

/**
 * Product Indexer
 */
class ProductIndexer extends AbstractIndexer
{
    /**
     * Product Collection
     * 
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected $_productCollection;
    
    /**
     * UrlRewrite Generator
     * 
     * @var \Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator
     */
    protected $_urlRewriteGenerator;

    /**
     * Initialize Indexer
     * 
     * @param ProductCollection $productCollection
     * @param ProductUrlRewriteGenerator $productUrlRewriteGenerator
     * @param UrlPersistInterface $urlPersist
     * @param StoreManagerInterface $storeManager     
     */
    public function __construct(
        ProductCollection $productCollection,
        ProductUrlRewriteGenerator $productUrlRewriteGenerator,      
        UrlPersistInterface $urlPersist,
        StoreManagerInterface $storeManager
    ) {
        $this->_productCollection = $productCollection;
        $this->_urlRewriteGenerator = $productUrlRewriteGenerator;

        parent::__construct(
			$urlPersist, 
			$storeManager
		);
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
		return $this->_urlRewriteGenerator;
	}
}

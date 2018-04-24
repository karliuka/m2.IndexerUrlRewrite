<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator;
use Magento\UrlRewrite\Model\UrlPersistInterface;

use Magento\Store\Model\StoreManagerInterface;

/**
 * IndexerUrlRewrite category indexer model
 */
class CategoryIndexer extends AbstractIndexer
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\Collection
     */
    protected $_categoryCollection;
    
    /**
     * @var \Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator
     */
    protected $_categoryUrlRewriteGenerator;



    protected $_storeManager;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Category\Collection $categoryCollection
     * @param \Magento\Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator
     * @param \Magento\UrlRewrite\Model\UrlPersistInterface $urlPersist
     */
    public function __construct(
        CategoryCollection $categoryCollection,
        CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator,        
        UrlPersistInterface $urlPersist,
        StoreManagerInterface $storeManager
    ) {
        $this->_categoryCollection = $categoryCollection;
        $this->_categoryUrlRewriteGenerator = $categoryUrlRewriteGenerator;
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
		$this->_categoryCollection->clear();
		$this->_categoryCollection->setStoreId($storeId)
			->addAttributeToSelect(['url_path', 'url_key'])
			->addAttributeToFilter('level', array('gt' => 1));

		return $this->_categoryCollection;
	}
    
    /**
     * Retrieve entity type
     *
     * @return string
     */
	protected function getEntityType()
	{
		return CategoryUrlRewriteGenerator::ENTITY_TYPE;	
	}
    
    /**
     * Retrieve entity rewrite generator
     *
     * @return object
     */
	protected function getRewriteGenerator()
	{
		return $this->_categoryUrlRewriteGenerator;
	}
}

<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_IndexerUrlRewrite
 * @copyright   Copyright (c) 2017 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\UrlRewrite\Model\UrlPersistInterface;

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
        
    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     * @param \Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator $productUrlRewriteGenerator
     * @param \Magento\UrlRewrite\Model\UrlPersistInterface $urlPersist
     */
    public function __construct(
        ProductCollection $productCollection,
        ProductUrlRewriteGenerator $productUrlRewriteGenerator,      
        UrlPersistInterface $urlPersist
    ) {
        $this->_productCollection = $productCollection;
        $this->_productUrlRewriteGenerator = $productUrlRewriteGenerator;       
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

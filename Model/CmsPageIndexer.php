<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Cms\Model\ResourceModel\Page\Collection as CmsPageCollection;
use Magento\Store\Model\StoreManagerInterface;
use Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator;
use Magento\UrlRewrite\Model\UrlPersistInterface;

/**
 * CmsPage Indexer
 */
class CmsPageIndexer extends AbstractIndexer
{
    /**
     * CmsPage Collection
     * 
     * @var \Magento\Cms\Model\ResourceModel\Page\Collection
     */
    protected $_cmsPageCollection;
    
    /**
     * UrlRewrite Generator
     * 
     * @var \Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator
     */
    protected $_urlRewriteGenerator;

    /**
     * Initialize Indexer
     * 
     * @param CmsPageCollection $cmsPageCollection
     * @param CmsPageUrlRewriteGenerator $cmsPageUrlRewriteGenerator
     * @param UrlPersistInterface $urlPersist
     * @param StoreManagerInterface $storeManager     
     */
    public function __construct(
        CmsPageCollection $cmsPageCollection,
        CmsPageUrlRewriteGenerator $cmsPageUrlRewriteGenerator,        
        UrlPersistInterface $urlPersist,
        StoreManagerInterface $storeManager
    ) {
        $this->_cmsPageCollection = $cmsPageCollection;
        $this->_urlRewriteGenerator = $cmsPageUrlRewriteGenerator;

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
		$this->_cmsPageCollection
			->addStoreFilter($storeId)
			->addFieldToSelect(['identifier']);
			
		return $this->_cmsPageCollection;
	}
    
    /**
     * Retrieve entity type
     *
     * @return string
     */
	protected function getEntityType()
	{
		return CmsPageUrlRewriteGenerator::ENTITY_TYPE;	
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

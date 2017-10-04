<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Cms\Model\ResourceModel\Page\Collection as CmsPageCollection;
use Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator;
use Magento\UrlRewrite\Model\UrlPersistInterface;

/**
 * IndexerUrlRewrite cms page indexer model
 */
class CmsPageIndexer extends AbstractIndexer
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\Collection
     */
    protected $_cmsPageCollection;
    
    /**
     * @var \Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator
     */
    protected $_cmsPageUrlRewriteGenerator;  
        
    /**
     * @param \Magento\Cms\Model\ResourceModel\Page\Collection $cmsPageCollection
     * @param \Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator $cmsPageUrlRewriteGenerator
     * @param \Magento\UrlRewrite\Model\UrlPersistInterface $urlPersist
     */
    public function __construct(
        CmsPageCollection $cmsPageCollection,
        CmsPageUrlRewriteGenerator $cmsPageUrlRewriteGenerator,        
        UrlPersistInterface $urlPersist
    ) {
        $this->_cmsPageCollection = $cmsPageCollection;
        $this->_cmsPageUrlRewriteGenerator = $cmsPageUrlRewriteGenerator;        
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
		return $this->_cmsPageUrlRewriteGenerator;
	}
}

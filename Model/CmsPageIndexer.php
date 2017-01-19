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

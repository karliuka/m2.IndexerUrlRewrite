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

use Magento\Framework\Mview\ActionInterface as MviewActionInterface;
use Magento\Framework\Indexer\ActionInterface as IndexerActionInterface;
use Magento\Store\Model\Store;
use Magento\Cms\Model\ResourceModel\Page\Collection as CmsPageCollection;
use Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

class CmsPageIndexer implements IndexerActionInterface, MviewActionInterface
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
     * @var \Magento\UrlRewrite\Model\UrlPersistInterface
     */     
    protected $_urlPersist;
        
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
        $this->_urlPersist = $urlPersist;
    }
    	
    /**
     * Execute materialization on ids entities
     *
     * @param int[] $ids
     * @return void
     */
    public function execute($ids)
    {
    }

    /**
     * Execute full indexation
     *
     * @return void
     */
    public function executeFull()
    {
		$this->_cmsPageCollection
			->addStoreFilter(Store::DEFAULT_STORE_ID)
			->addFieldToSelect(['identifier']);
 
		foreach($this->_cmsPageCollection as $cmsPage) { 
            $this->_urlPersist->deleteByData([
                UrlRewrite::ENTITY_ID => $cmsPage->getId(),
                UrlRewrite::ENTITY_TYPE => CmsPageUrlRewriteGenerator::ENTITY_TYPE,
                UrlRewrite::REDIRECT_TYPE => 0,
                UrlRewrite::STORE_ID => Store::DEFAULT_STORE_ID
            ]);
            try {
                $this->_urlPersist->replace(
                    $this->_cmsPageUrlRewriteGenerator->generate($cmsPage)
                );
                $cmsPage->getId();
            } catch(\Exception $e) {
				// add log
            }
        }          		
    }

    /**
     * Execute partial indexation by ID list
     *
     * @param int[] $ids
     * @return void
     */
    public function executeList(array $ids)
    {
    }

    /**
     * Execute partial indexation by ID
     *
     * @param int $id
     * @return void
     */
    public function executeRow($id)
    {
    }
}

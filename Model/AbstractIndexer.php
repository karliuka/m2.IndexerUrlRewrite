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
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

/**
 * IndexerUrlRewrite abstract indexer model
 */
abstract class AbstractIndexer implements IndexerActionInterface, MviewActionInterface
{         
    /**
     * @var \Magento\UrlRewrite\Model\UrlPersistInterface
     */     
    protected $_urlPersist;
        
    /**
     * @param \Magento\UrlRewrite\Model\UrlPersistInterface $urlPersist
     */
    public function __construct(     
        UrlPersistInterface $urlPersist
    ) {      
        $this->_urlPersist = $urlPersist;
    }
    
    /**
     * Retrieve entity collection
     *
     * @param integer $storeId
     * @return object
     */
	abstract protected function getEntityCollection($storeId);
    
    /**
     * Retrieve entity type
     *
     * @return string
     */
	abstract protected function getEntityType();
    
    /**
     * Retrieve entity rewrite generator
     *
     * @return object
     */
	abstract protected function getRewriteGenerator();
            
    /**
     * Execute full indexation
     *
     * @return void
     */
    public function executeFull()
    {	
        foreach($this->getEntityCollection(Store::DEFAULT_STORE_ID) as $entity) {
            $this->deleteByEntity($entity);
            try {
                $this->_urlPersist->replace(
                    $this->getRewriteGenerator()->generate($entity)
                );
            } catch(\Exception $e) {
				// add log
            }
        }  		
    }
    
    /**
     * Remove rewrites 
     *
     * @param object $entity
     * @return void
     */
    protected function deleteByEntity($entity)
    {
		$this->_urlPersist->deleteByData([
			UrlRewrite::ENTITY_ID => $entity->getId(),
			UrlRewrite::ENTITY_TYPE => $this->getEntityType(),
			UrlRewrite::REDIRECT_TYPE => 0,
			UrlRewrite::STORE_ID => Store::DEFAULT_STORE_ID
		]);	
	}
    	
    /**
     * Execute materialization on ids entities
     *
     * @param int[] $ids
     * @return void
     */
    public function execute($ids){}
    
    /**
     * Execute partial indexation by ID list
     *
     * @param int[] $ids
     * @return void
     */
    public function executeList(array $ids){}

    /**
     * Execute partial indexation by ID
     *
     * @param int $id
     * @return void
     */
    public function executeRow($id){}
}

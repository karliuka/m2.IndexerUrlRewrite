<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Framework\Mview\ActionInterface as MviewActionInterface;
use Magento\Framework\Indexer\ActionInterface as IndexerActionInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

/**
 * Abstract Indexer
 */
abstract class AbstractIndexer implements IndexerActionInterface, MviewActionInterface
{         
    /**
     * Url Persist
     * 
     * @var \Magento\UrlRewrite\Model\UrlPersistInterface
     */     
    protected $_urlPersist;
    
    /**
     * Store Manager
     * 
     * @var \Magento\UrlRewrite\Model\UrlPersistInterface
     */ 
    protected $_storeManager;
        
    /**
     * Initialize Indexer
     * 
     * @param UrlPersistInterface $urlPersist
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(     
        UrlPersistInterface $urlPersist,
        StoreManagerInterface $storeManager
    ) {      
        $this->_urlPersist = $urlPersist;
        $this->_storeManager = $storeManager;
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
        foreach ($this->_storeManager->getStores() as $store){
            $this->_storeManager->setCurrentStore($store->getId());
            $this->executeStore($store->getId());
        }
    }
    
    /**
     * Execute indexation from store
     *
     * @return void
     */
    private function executeStore($storeId){
        foreach($this->getEntityCollection($storeId) as $entity) {
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
		$storeId = $entity->getStore() 
			? $entity->getStore()->getId() 
			: Store::DEFAULT_STORE_ID;
			
		$this->_urlPersist->deleteByData([
			UrlRewrite::ENTITY_ID => $entity->getId(),
			UrlRewrite::ENTITY_TYPE => $this->getEntityType(),
			UrlRewrite::REDIRECT_TYPE => 0,
			UrlRewrite::STORE_ID => $storeId
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

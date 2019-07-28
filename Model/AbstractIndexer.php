<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Mview\ActionInterface as MviewActionInterface;
use Magento\Framework\Indexer\ActionInterface as IndexerActionInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Psr\Log\LoggerInterface;

/**
 * Abstract Indexer
 */
abstract class AbstractIndexer implements IndexerActionInterface, MviewActionInterface
{
    /**
     * Url Persist
     *
     * @var UrlPersistInterface
     */
    private $urlPersist;

    /**
     * Store Manager
     *
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize Indexer
     *
     * @param UrlPersistInterface $urlPersist
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        UrlPersistInterface $urlPersist,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger
    ) {
        $this->urlPersist = $urlPersist;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * Retrieve entity collection
     *
     * @param integer $storeId
     * @return \Magento\Framework\Data\Collection\AbstractDb
     */
    abstract protected function getEntityCollection($storeId);

    /**
     * Retrieve entity type
     *
     * @return string
     */
    abstract protected function getEntityType();

    /**
     * Generate url rewrites
     *
     * @param AbstractModel $entity
     * @return \Magento\UrlRewrite\Service\V1\Data\UrlRewrite[]
     */
    abstract protected function generate($entity);

    /**
     * Execute full indexation
     *
     * @return void
     */
    public function executeFull()
    {
        foreach ($this->storeManager->getStores() as $store) {
            $this->storeManager->setCurrentStore((string)$store->getId());
            $this->executeStore($store->getId());
        }
    }

    /**
     * Execute indexation from store
     *
     * @param integer $storeId
     * @return void
     */
    private function executeStore($storeId)
    {
        foreach ($this->getEntityCollection($storeId) as $entity) {
            $this->deleteByEntity($entity);
            try {
                $this->urlPersist->replace($this->generate($entity));
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }
    }

    /**
     * Retrieve store id
     *
     * @param AbstractModel $entity
     * @return string
     */
    private function getStoreId(AbstractModel $entity)
    {
        return method_exists($entity, 'getStore') && $entity->getStore()
            ? $entity->getStore()->getId()
            : Store::DEFAULT_STORE_ID;
    }

    /**
     * Remove rewrites
     *
     * @param AbstractModel $entity
     * @return void
     */
    private function deleteByEntity(AbstractModel $entity)
    {
        $this->urlPersist->deleteByData([
            UrlRewrite::ENTITY_ID => $entity->getId(),
            UrlRewrite::ENTITY_TYPE => $this->getEntityType(),
            UrlRewrite::REDIRECT_TYPE => 0,
            UrlRewrite::STORE_ID => $this->getStoreId($entity)
        ]);
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

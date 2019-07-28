<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Mview\ActionInterface as MviewActionInterface;
use Magento\Framework\Indexer\ActionInterface as IndexerActionInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

/**
 * Abstract indexer
 */
abstract class AbstractIndexer implements IndexerActionInterface, MviewActionInterface
{
    /**
     * Url persist
     *
     * @var \Magento\UrlRewrite\Model\UrlPersistInterface
     */
    private $urlPersist;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * Logger
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Initialize Indexer
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->urlPersist = $context->getUrlPersist();
        $this->storeManager = $context->getStoreManager();
        $this->logger = $context->getLogger();
    }

    /**
     * Retrieve entity collection
     *
     * @param integer $storeId
     * @param integer[] $ids
     * @return \Magento\Framework\Data\Collection\AbstractDb
     */
    abstract protected function getEntityCollection($storeId, array $ids = []);

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
     * Execute indexation from store
     *
     * @param integer $storeId
     * @param integer[] $ids
     * @return void
     */
    private function executeStore($storeId, array $ids = [])
    {
        foreach ($this->getEntityCollection($storeId, $ids) as $entity) {
            $this->deleteEntity($entity->getId(), $storeId);
            try {
                $this->urlPersist->replace($this->generate($entity));
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }
    }

    /**
     * Remove rewrites
     *
     * @param integer $entityId
     * @param integer $storeId
     * @return void
     */
    private function deleteEntity($entityId, $storeId)
    {
        $this->urlPersist->deleteByData([
            UrlRewrite::ENTITY_ID => $entityId,
            UrlRewrite::ENTITY_TYPE => $this->getEntityType(),
            UrlRewrite::REDIRECT_TYPE => 0,
            UrlRewrite::STORE_ID => $storeId
        ]);
    }

    /**
     * Execute materialization on ids entities
     *
     * @param integer[] $ids
     * @return void
     */
    public function execute($ids)
    {
        foreach ($this->storeManager->getStores() as $store) {
            $this->storeManager->setCurrentStore((string)$store->getId());
            $this->executeStore($store->getId(), $ids);
        }
    }

    /**
     * Execute full indexation
     *
     * @return void
     */
    public function executeFull()
    {
        $this->execute([]);
    }

    /**
     * Execute partial indexation by ID list
     *
     * @param integer[] $ids
     * @return void
     */
    public function executeList(array $ids)
    {
        $this->execute($ids);
    }

    /**
     * Execute partial indexation by ID
     *
     * @param integer $id
     * @return void
     */
    public function executeRow($id)
    {
        $this->execute([$id]);
    }
}

<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Psr\Log\LoggerInterface;

/**
 * Indexer context
 */
class Context
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
     * Initialize context
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
     * Retrieve url persist
     *
     * @return UrlPersistInterface
     */
    public function getUrlPersist()
    {
        return $this->urlPersist;
    }

    /**
     * Retrieve store manager
     *
     * @return StoreManagerInterface
     */
    public function getStoreManager()
    {
        return $this->storeManager;
    }

    /**
     * Retrieve logger
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }
}

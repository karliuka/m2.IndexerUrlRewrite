<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Cms\Model\ResourceModel\Page\Collection as CmsPageCollection;
use Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Psr\Log\LoggerInterface;

/**
 * CmsPage Indexer
 */
class CmsPageIndexer extends AbstractIndexer
{
    /**
     * CmsPage Collection
     *
     * @var CmsPageCollection
     */
    private $cmsPageCollection;

    /**
     * UrlRewrite Generator
     *
     * @var CmsPageUrlRewriteGenerator
     */
    private $urlRewriteGenerator;

    /**
     * Initialize Indexer
     *
     * @param UrlPersistInterface $urlPersist
     * @param StoreManagerInterface $storeManager
     * @param CmsPageCollection $cmsPageCollection
     * @param CmsPageUrlRewriteGenerator $cmsPageUrlRewriteGenerator
     * @param LoggerInterface $logger
     */
    public function __construct(
        UrlPersistInterface $urlPersist,
        StoreManagerInterface $storeManager,
        CmsPageCollection $cmsPageCollection,
        CmsPageUrlRewriteGenerator $cmsPageUrlRewriteGenerator,
        LoggerInterface $logger
    ) {
        $this->cmsPageCollection = $cmsPageCollection;
        $this->urlRewriteGenerator = $cmsPageUrlRewriteGenerator;

        parent::__construct(
            $urlPersist,
            $storeManager,
            $logger
        );
    }

    /**
     * Retrieve entity collection
     *
     * @param integer $storeId
     * @return \Magento\Framework\Data\Collection\AbstractDb
     */
    protected function getEntityCollection($storeId)
    {
        $this->cmsPageCollection
            ->addStoreFilter($storeId)
            ->addFieldToSelect(['identifier']);

        return $this->cmsPageCollection;
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
     * Generate url rewrites
     *
     * @param \Magento\Cms\Model\Page $entity
     * @return \Magento\UrlRewrite\Service\V1\Data\UrlRewrite[]
     */
    protected function generate($entity)
    {
        return $this->urlRewriteGenerator->generate($entity);
    }
}

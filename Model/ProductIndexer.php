<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Psr\Log\LoggerInterface;

/**
 * Product Indexer
 */
class ProductIndexer extends AbstractIndexer
{
    /**
     * Product Collection
     *
     * @var ProductCollection
     */
    private $productCollection;

    /**
     * UrlRewrite Generator
     *
     * @var ProductUrlRewriteGenerator
     */
    private $urlRewriteGenerator;

    /**
     * Initialize Indexer
     *
     * @param UrlPersistInterface $urlPersist
     * @param StoreManagerInterface $storeManager
     * @param ProductCollection $productCollection
     * @param ProductUrlRewriteGenerator $productUrlRewriteGenerator
     * @param LoggerInterface $logger
     */
    public function __construct(
        UrlPersistInterface $urlPersist,
        StoreManagerInterface $storeManager,
        ProductCollection $productCollection,
        ProductUrlRewriteGenerator $productUrlRewriteGenerator,
        LoggerInterface $logger
    ) {
        $this->productCollection = $productCollection;
        $this->urlRewriteGenerator = $productUrlRewriteGenerator;

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
        $this->productCollection->clear();
        $this->productCollection->setStoreId($storeId)
            ->addAttributeToSelect(['url_path', 'url_key']);

        return $this->productCollection;
    }

    /**
     * Retrieve entity type
     *
     * @return string
     */
    protected function getEntityType()
    {
        return ProductUrlRewriteGenerator::ENTITY_TYPE;
    }

    /**
     * Generate url rewrites
     *
     * @param \Magento\Catalog\Model\Product $entity
     * @return \Magento\UrlRewrite\Service\V1\Data\UrlRewrite[]
     */
    protected function generate($entity)
    {
        return $this->urlRewriteGenerator->generate($entity);
    }
}

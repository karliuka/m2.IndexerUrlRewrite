<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;

/**
 * Product indexer
 */
class ProductIndexer extends AbstractIndexer
{
    /**
     * Product collection
     *
     * @var ProductCollection
     */
    private $productCollection;

    /**
     * UrlRewrite generator
     *
     * @var ProductUrlRewriteGenerator
     */
    private $urlRewriteGenerator;

    /**
     * Initialize indexer
     *
     * @param Context $context
     * @param ProductCollection $productCollection
     * @param ProductUrlRewriteGenerator $productUrlRewriteGenerator
     */
    public function __construct(
        Context $context,
        ProductCollection $productCollection,
        ProductUrlRewriteGenerator $productUrlRewriteGenerator
    ) {
        $this->productCollection = $productCollection;
        $this->urlRewriteGenerator = $productUrlRewriteGenerator;

        parent::__construct(
            $context
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

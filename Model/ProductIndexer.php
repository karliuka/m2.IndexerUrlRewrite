<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;

/**
 * Product indexer
 */
class ProductIndexer extends AbstractIndexer
{
    /**
     * Product collection factory
     *
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

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
     * @param ProductCollectionFactory $productCollectionFactory
     * @param ProductUrlRewriteGenerator $productUrlRewriteGenerator
     */
    public function __construct(
        Context $context,
        ProductCollectionFactory $productCollectionFactory,
        ProductUrlRewriteGenerator $productUrlRewriteGenerator
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->urlRewriteGenerator = $productUrlRewriteGenerator;

        parent::__construct(
            $context
        );
    }

    /**
     * Retrieve entity collection
     *
     * @param integer $storeId
     * @param integer[] $ids
     * @return \Magento\Framework\Data\Collection\AbstractDb
     */
    protected function getEntityCollection($storeId, array $ids = [])
    {
        $collection = $this->productCollectionFactory->create();
        if (count($ids)) {
            $collection->addAttributeToFilter('entity_id', ['in' => $ids]);
        }

        $collection->setStoreId($storeId)
            ->addAttributeToSelect(['url_path', 'url_key']);

        return $collection;
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

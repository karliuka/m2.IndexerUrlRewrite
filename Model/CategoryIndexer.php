<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator;

/**
 * Category indexer
 */
class CategoryIndexer extends AbstractIndexer
{
    /**
     * Category collection factory
     *
     * @var CategoryCollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * UrlRewrite generator
     *
     * @var CategoryUrlRewriteGenerator
     */
    private $urlRewriteGenerator;

    /**
     * Initialize indexer
     *
     * @param Context $context
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator
     */
    public function __construct(
        Context $context,
        CategoryCollectionFactory $categoryCollectionFactory,
        CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->urlRewriteGenerator = $categoryUrlRewriteGenerator;

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
        $collection = $this->categoryCollectionFactory->create();
        if (count($ids)) {
            $collection->addAttributeToFilter('entity_id', ['in' => $ids]);
        }

        $collection->setStoreId($storeId)
            ->addAttributeToSelect(['url_path', 'url_key'])
            ->addAttributeToFilter('level', ['gt' => 1]);

        return $collection;
    }

    /**
     * Retrieve entity type
     *
     * @return string
     */
    protected function getEntityType()
    {
        return CategoryUrlRewriteGenerator::ENTITY_TYPE;
    }

    /**
     * Generate url rewrites
     *
     * @param \Magento\Catalog\Model\Category $entity
     * @return \Magento\UrlRewrite\Service\V1\Data\UrlRewrite[]
     */
    protected function generate($entity)
    {
        return $this->urlRewriteGenerator->generate($entity);
    }
}

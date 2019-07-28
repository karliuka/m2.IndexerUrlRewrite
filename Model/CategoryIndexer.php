<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator;

/**
 * Category indexer
 */
class CategoryIndexer extends AbstractIndexer
{
    /**
     * Category collection
     *
     * @var CategoryCollection
     */
    private $categoryCollection;

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
     * @param CategoryCollection $categoryCollection
     * @param CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator
     */
    public function __construct(
        Context $context,
        CategoryCollection $categoryCollection,
        CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator
    ) {
        $this->categoryCollection = $categoryCollection;
        $this->urlRewriteGenerator = $categoryUrlRewriteGenerator;

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
        $this->categoryCollection->clear();
        $this->categoryCollection->setStoreId($storeId)
            ->addAttributeToSelect(['url_path', 'url_key'])
            ->addAttributeToFilter('level', ['gt' => 1]);

        return $this->categoryCollection;
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

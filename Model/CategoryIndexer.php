<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 *
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\UrlPersistInterface;

/**
 * Category Indexer
 */
class CategoryIndexer extends AbstractIndexer
{
    /**
     * Category Collection
     *
     * @var CategoryCollection
     */
    private $categoryCollection;

    /**
     * UrlRewrite Generator
     *
     * @var CategoryUrlRewriteGenerator
     */
    private $urlRewriteGenerator;

    /**
     * Initialize Indexer
     *
     * @param UrlPersistInterface $urlPersist
     * @param StoreManagerInterface $storeManager
     * @param CategoryCollection $categoryCollection
     * @param CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator
     */
    public function __construct(
        UrlPersistInterface $urlPersist,
        StoreManagerInterface $storeManager,
        CategoryCollection $categoryCollection,
        CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator
    ) {
        $this->categoryCollection = $categoryCollection;
        $this->urlRewriteGenerator = $categoryUrlRewriteGenerator;

        parent::__construct(
            $urlPersist,
            $storeManager
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

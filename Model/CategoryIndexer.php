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
     * @var \Magento\Catalog\Model\ResourceModel\Category\Collection
     */
    protected $_categoryCollection;

    /**
     * UrlRewrite Generator
     *
     * @var \Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator
     */
    protected $_urlRewriteGenerator;
    /**
     * Initialize Indexer
     *
     * @param CategoryCollection $categoryCollection
     * @param CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator
     * @param UrlPersistInterface $urlPersist
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        CategoryCollection $categoryCollection,
        CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator,
        UrlPersistInterface $urlPersist,
        StoreManagerInterface $storeManager
    ) {
        $this->_categoryCollection = $categoryCollection;
        $this->_urlRewriteGenerator = $categoryUrlRewriteGenerator;

        parent::__construct(
            $urlPersist,
            $storeManager
        );
    }

    /**
     * Retrieve entity collection
     *
     * @param integer $storeId
     * @return object
     */
    protected function getEntityCollection($rootCategoryId)
    {
        $this->_categoryCollection->clear();

        $this->_categoryCollection
            ->addAttributeToSelect(['url_path', 'url_key', '*'])
            ->addAttributeToFilter('level', array('gt' => 0))
            ->addFieldToFilter('path', array('like' => "%/{$rootCategoryId}/%"));

        return $this->_categoryCollection;
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
     * Retrieve entity rewrite generator
     *
     * @return object
     */
    protected function getRewriteGenerator()
    {
        return $this->_urlRewriteGenerator;
    }
}

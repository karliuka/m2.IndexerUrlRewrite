<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\IndexerUrlRewrite\Model;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as CmsPageCollectionFactory;
use Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator;

/**
 * CmsPage Indexer
 */
class CmsPageIndexer extends AbstractIndexer
{
    /**
     * CmsPage collection factory
     *
     * @var CmsPageCollectionFactory
     */
    private $cmsPageCollectionFactory;

    /**
     * UrlRewrite generator
     *
     * @var CmsPageUrlRewriteGenerator
     */
    private $urlRewriteGenerator;

    /**
     * Initialize indexer
     *
     * @param Context $context
     * @param CmsPageCollectionFactory $cmsPageCollectionFactory
     * @param CmsPageUrlRewriteGenerator $cmsPageUrlRewriteGenerator
     */
    public function __construct(
        Context $context,
        CmsPageCollectionFactory $cmsPageCollectionFactory,
        CmsPageUrlRewriteGenerator $cmsPageUrlRewriteGenerator
    ) {
        $this->cmsPageCollectionFactory = $cmsPageCollectionFactory;
        $this->urlRewriteGenerator = $cmsPageUrlRewriteGenerator;

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
        $collection = $this->cmsPageCollectionFactory->create();
        if (count($ids)) {
            $collection->addFieldToFilter('page_id', ['in' => $ids]);
        }

        $collection->addStoreFilter($storeId)
            ->addFieldToSelect(['identifier']);

        return $collection;
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

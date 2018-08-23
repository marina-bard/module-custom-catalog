<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/15/18
 * Time: 6:16 PM
 */

namespace Magento\CustomCatalog\Model\ResourceModel\Product;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\CustomCatalog\Model\Product;
use Magento\CustomCatalog\Model\ResourceModel\Product as ProductResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'stacklevel_customcatalog_product_collection';
    protected $_eventObject = 'product_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Product::class, ProductResourceModel::class);
    }
}
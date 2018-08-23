<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/15/18
 * Time: 5:29 PM
 */

namespace Magento\CustomCatalog\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\CustomCatalog\Model\ResourceModel\Product as ProductResourceModel;

class Product extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'stacklevel_customcatalog_product';

    protected $_cacheTag = 'stacklevel_customcatalog_product';

    protected $_eventPrefix = 'stacklevel_customcatalog_product';

    protected function _construct()
    {
        $this->_init(ProductResourceModel::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
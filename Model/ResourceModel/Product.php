<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/15/18
 * Time: 6:09 PM
 */

namespace Magento\CustomCatalog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Product extends AbstractDb
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('stacklevel_customcatalog_product', 'entity_id');
    }
}
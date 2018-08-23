<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/19/18
 * Time: 2:40 PM
 */

namespace Magento\CustomCatalog\Api;

use Magento\Framework\DataObject;
use Magento\CustomCatalog\Api\Data\ProductDataInterface;

interface ProductManagerInterface
{
    /**
     * @param string $vpn
     * @return DataObject[]|ProductManagerInterface
     */
    public function getByVpn($vpn);

    /**
     * @param \Magento\CustomCatalog\Api\Data\ProductDataInterface $data
     * @return \Magento\CustomCatalog\Api\Data\ProductDataInterface
     */
    public function update(ProductDataInterface $data);
}
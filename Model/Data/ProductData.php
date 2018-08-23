<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/19/18
 * Time: 5:15 PM
 */

namespace Magento\CustomCatalog\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Magento\CustomCatalog\Api\Data\ProductDataInterface;

class ProductData extends AbstractExtensibleObject implements ProductDataInterface
{
    /**
     * @return int|null
     */
    public function getEntityId()
    {
        return $this->_get(self::ENTITY_ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setEntityId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * @return string
     */
    public function getCopywriteInfo()
    {
        return $this->_get(self::COPYWRITE_INFO);
    }

    /**
     * @param string $copywriteInfo
     * @return $this
     */
    public function setCopywriteInfo($copywriteInfo = null)
    {
        return $this->setData(self::COPYWRITE_INFO, $copywriteInfo);
    }

    /**
     * @return string
     */
    public function getVpn()
    {
        return $this->_get(self::VPN);
    }

    /**
     * @param string $vpn
     * @return $this
     */
    public function setVpn($vpn = null)
    {
        return $this->setData(self::VPN, $vpn);
    }
}
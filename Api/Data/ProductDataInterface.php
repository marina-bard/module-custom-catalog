<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/19/18
 * Time: 5:04 PM
 */

namespace Magento\CustomCatalog\Api\Data;

use Magento\Framework\Api\CustomAttributesDataInterface;

interface ProductDataInterface extends CustomAttributesDataInterface
{
    const ENTITY_ID = 'entity_id';

    const COPYWRITE_INFO = 'copywrite_info';

    const VPN = 'vpn';

    /**
     * @return int|null
     */
    public function getEntityId();

    /**
     * @param int $id
     * @return $this
     */
    public function setEntityId($id);

    /**
     * @return string
     */
    public function getCopywriteInfo();

    /**
     * @param string $copywriteInfo
     * @return $this
     */
    public function setCopywriteInfo($copywriteInfo = null);

    /**
     * @return string
     */
    public function getVpn();

    /**
     * @param string $vpn
     * @return $this
     */
    public function setVpn($vpn = null);
}
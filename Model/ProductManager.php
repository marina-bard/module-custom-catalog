<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/19/18
 * Time: 2:42 PM
 */

namespace Magento\CustomCatalog\Model;

use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\DataObject;
use Magento\CustomCatalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Magento\CustomCatalog\Api\ProductManagerInterface;
use Magento\CustomCatalog\Api\Data\ProductDataInterface;

class ProductManager implements ProductManagerInterface
{
    /**
     * @var Collection $collection
     */
    protected $collection;

    /**
     * @var ObjectManagerInterface $objectManager
     */
    protected $objectManager;

    /**
     * @var ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var DeploymentConfig $deploymentConfig
     */
    protected $deploymentConfig;

    /**
     * ProductManager constructor.
     * @param Collection $collection
     * @param ObjectManagerInterface $objectManager
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param DeploymentConfig $deploymentConfig
     */
    public function __construct(
        Collection $collection,
        ObjectManagerInterface$objectManager,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        DeploymentConfig $deploymentConfig
    ) {
        $this->collection = $collection;
        $this->objectManager = $objectManager;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->deploymentConfig = $deploymentConfig;
    }

    /**
     * @param string $vpn
     * @return DataObject[]|ProductManagerInterface
     */
    public function getByVpn($vpn)
    {
        $items = $this->collection->addFieldToFilter('vpn', $vpn)->getData();
        return $items;
    }

    /**
     * @param ProductDataInterface $data
     * @return ProductDataInterface
     */
    public function update(ProductDataInterface $data) {
        $productData = $this->extensibleDataObjectConverter->toNestedArray(
            $data,
            [],
            ProductDataInterface::class
        );

        $productData = serialize($productData);

        $config = $this->deploymentConfig->get('queue/amqp');

        $connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password']
        );
        $channel = $connection->channel();

        $channel->queue_declare('update', false, false, false, false);

        $msg = new AMQPMessage($productData);
        $channel->basic_publish($msg, '', 'update');

        $channel->close();
        $connection->close();

        return $data;
    }
}
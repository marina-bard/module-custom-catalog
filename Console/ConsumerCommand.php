<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/21/18
 * Time: 12:41 PM
 */

namespace Magento\CustomCatalog\Console;

use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\Exception\InputException;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Magento\CustomCatalog\Model\Product;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
USE Magento\Framework\App\ObjectManager;

class ConsumerCommand extends Command
{
    /**
     * @var DeploymentConfig $deploymentConfig
     */
    protected $deploymentConfig;

    public function __construct(
        DeploymentConfig $deploymentConfig,
        $name = null
    )
    {
        $this->deploymentConfig = $deploymentConfig;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('customcatalog:consumer');
        $this->setDescription('Run RabbiMQ handler named Consumer');

        parent::configure();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->deploymentConfig->get('rabbitmq');

        $connection = new AMQPStreamConnection(
            $config['amqp-host'],
            $config['amqp-port'],
            $config['amqp-user'],
            $config['amqp-password']
        );
        $channel = $connection->channel();
        $channel->queue_declare('update', false, false, false, false);

        $callback = function ($msg) {
            $objectManager = ObjectManager::getInstance();

            $productData = unserialize($msg->body);

            $id = $productData['entity_id'];
            $product = $objectManager->create(Product::class);
            $product->load($id);

            if (!$product->getData()) {
                throw new InputException(__("Product with provided %entity_id does not exist", ['entity_id' => $id]));
            }

            $product->setData($productData);
            $product->save();
        };

        $channel->basic_consume('update', '', false, true, false, false, $callback);
        while (count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }

}
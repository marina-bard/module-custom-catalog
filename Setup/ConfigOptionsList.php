<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CustomCatalog\Setup;

use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\Config\Data\ConfigData;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Framework\Setup\ConfigOptionsListInterface;
use Magento\Framework\Setup\Option\TextConfigOption;

class ConfigOptionsList implements ConfigOptionsListInterface
{
    const CUSTOM_CONFIG_OPTIONS = [
        'amqp-host' => '127.0.0.1',
        'amqp-port' => '5672',
        'amqp-user' => 'guest',
        'amqp-password' => 'guest',
    ];

    const CUSTOM_CONFIG_PATH = 'rabbitmq/';

    const DESCRIPTION = "RabbitMQ custom deployment configuration";
    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        $options = [];

        foreach (self::CUSTOM_CONFIG_OPTIONS as $key => $value) {
            $options[] = new TextConfigOption(
                $key,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                self::CUSTOM_CONFIG_PATH . $key,
                self::DESCRIPTION
            );
        }

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function createConfig(array $options, DeploymentConfig $deploymentConfig)
    {
        $configData = new ConfigData(ConfigFilePool::APP_CONFIG);

        foreach (self::CUSTOM_CONFIG_OPTIONS as $key => $value) {
            if (isset($options[$key])) {
                $configData->set(self::CUSTOM_CONFIG_PATH . $key, $options[$key]);
            } elseif ($deploymentConfig->get(self::CUSTOM_CONFIG_PATH . $key) === null) {
                $configData->set(self::CUSTOM_CONFIG_PATH . $key, $value);
            }
        }

        return [$configData];
    }

    /**
     * Suppress warning added because we are not using DeploymentConfig to validate user input here
     *
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function validate(array $options, DeploymentConfig $deploymentConfig)
    {
        return [];
    }
}
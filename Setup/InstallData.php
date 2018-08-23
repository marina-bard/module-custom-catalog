<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/10/18
 * Time: 12:39 PM
 */

namespace Magento\CustomCatalog\Setup;

use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Product::ENTITY,
            'copywrite_info',
            [
                'group' => 'General',
                'type' => 'varchar',
                'label' => 'Copy Write Information',
                'input' => 'text',
                'source' => '',
                'required' => false,
                'sort_order' => 10000,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]

        );

        $eavSetup->addAttribute(
            Product::ENTITY,
            'vpn',
            [
                'group' => 'General',
                'type' => 'varchar',
                'label' => 'Vendor Product Number',
                'input' => 'text',
                'source' => '',
                'required' => false,
                'sort_order' => 10000,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]

        );
    }
}
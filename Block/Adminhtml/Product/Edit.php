<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/17/18
 * Time: 11:37 AM
 */

namespace Magento\CustomCatalog\Block\Adminhtml\Product;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_product';
        $this->_blockGroup = 'Magento_CustomCatalog';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Product'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ],
            -100
        );
    }

    /**
     * Get header with Department name
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('customcatalog_product')->getId()) {
            return __("Edit Product '%1'", $this->escapeHtml($this->_coreRegistry->registry('customcatalog_product')->getName()));
        } else {
            return __('New Product');
        }
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('customcatalog/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}
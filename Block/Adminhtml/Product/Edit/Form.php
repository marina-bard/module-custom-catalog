<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/17/18
 * Time: 11:43 AM
 */

namespace Magento\CustomCatalog\Block\Adminhtml\Product\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Store\Model\System\Store;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;

class Form extends Generic
{
    /**
     * @var Store
     */
    protected $_systemStore;

    /**
     * Form constructor.
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Store $systemStore
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('product_form');
        $this->setTitle(__('Product Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\CustomCatalog\Model\Product $model */
        $model = $this->_coreRegistry->registry('customcatalog_product');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );

        $form->setHtmlIdPrefix('product_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('General Information'),
                'class' => 'fieldset-wide'
            ]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'entity_id',
                'hidden',
                ['name' => 'entity_id']
            );
        }

        $fieldset->addField(
            'copywrite_info',
            'text',
            [
                'name' => 'copywrite_info',
                'label' => __('Copy Write Info'),
                'required' => false,
            ]
        );
        $fieldset->addField(
            'vpn',
            'text',
            [
                'name'      => 'vpn',
                'label'     => __('VPN'),
                'required'  => true,
            ]
        );
        $fieldset->addField(
            'sku',
            'text',
            [
                'name'      => 'sku',
                'label'     => __('SKU'),
                'required'  => true,
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
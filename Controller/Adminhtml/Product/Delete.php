<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/18/18
 * Time: 6:00 PM
 */

namespace Magento\CustomCatalog\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\CustomCatalog\Model\Product;

class Delete extends Action
{
    protected $model;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param Product $model
     */
    public function __construct(
        Context $context,
        Product $model
    ) {
        parent::__construct($context);
        $this->model = $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_CustomCatalog::customcatalog');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $model = $this->model;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Product deleted'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addError(__('Product does not exist'));

        return $resultRedirect->setPath('*/*/');
    }

}
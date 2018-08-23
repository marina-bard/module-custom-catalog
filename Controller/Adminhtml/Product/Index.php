<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/15/18
 * Time: 7:23 PM
 */

namespace Magento\CustomCatalog\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\CustomCatalog\Model\ProductFactory;

class Index extends Action
{
    protected $resultPageFactory = false;

    protected $productFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ProductFactory $productFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->productFactory = $productFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Products')));

        return $resultPage;
    }
}
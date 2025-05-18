<?php

namespace Webkul\BlogManager\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

//widget form with block controller
class Edit extends Action
{
    protected $blogFactory;
    protected $coreRegistry;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Webkul\BlogManager\Model\BlogFactory $blogFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->blogFactory = $blogFactory;
    }
    public function execute()
    {
        $blogId = $this->getRequest()->getParam('id');
        $blogModel = $this->blogFactory->create()->load($blogId);
        $this->coreRegistry->register('blog_data', $blogModel);

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__("Edit Blog"));
        return $resultPage;
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_BlogManager::edit');
    }
}


/*
// ui form controller

class Edit extends Action
{
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage /
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__("Edit Blog"));
        return $resultPage;
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_BlogManager::edit');
    }
}
*/
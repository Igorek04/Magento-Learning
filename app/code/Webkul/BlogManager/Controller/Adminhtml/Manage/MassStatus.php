<?php

namespace Webkul\BlogManager\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Webkul\BlogManager\Model\ResourceModel\Blog\CollectionFactory;

class MassStatus extends Action
{
    public $collectionFactory;
    public $filter;
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $status = $this->getRequest()->getParam('status');
            $statusLabel = $status ? "enabled" : "disabled";
            $count = 0;
            foreach ($collection as $model) {
                $model->setStatus($status);
                $model->save();
                $count++;
            }
            $this->messageManager->addSuccessMessage(__('A total of %1 blog(s) have been %2.', $count, $statusLabel));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_BlogManager::edit');
    }
}

<?php

namespace Webkul\BlogManager\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Save extends Action
{
    protected $blogFactory;
    public function __construct(
        Context $context,
        \Webkul\BlogManager\Model\BlogFactory $blogFactory
    ) {
        $this->blogFactory = $blogFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getParams();
        if (isset($data['entity_id']) && $data['entity_id']) {

            $model = $this->blogFactory->create()->load($data['entity_id']);
            $model->setTitle($data['title'])
                ->setContent($data['content'])
                ->setStatus($data['status'])
                ->setUserId($data['user_id']);

            if (isset($data['products'])) {
                $model->setProducts(implode(',', $data['products']));

            } else {
                $model->setProducts('');
            }

            $model->save();
            $this->messageManager->addSuccess(__('You have updated the blog successfully.'));

        } else {
            $model = $this->blogFactory->create();
            $model->setTitle($data['title'])
                ->setContent($data['content'])
                ->setStatus($data['status'])
                ->setUserId($data['user_id']);

            if (isset($data['products'])) {
                $model->setProducts(implode(',', $data['products']));

            } else {
                $model->setProducts('');
            }

            $model->save();
            $this->messageManager->addSuccess(__('You have successfully created the blog.'));
        }
        return $resultRedirect->setPath('*/*/');
    }
    
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_BlogManager::save');
    }
}

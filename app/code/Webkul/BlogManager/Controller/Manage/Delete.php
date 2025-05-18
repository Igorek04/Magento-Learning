<?php

namespace Webkul\BlogManager\Controller\Manage;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\Action\Context;

class Delete extends AbstractAccount
{
    public $blogFactory;
    public $messageManager;
    public $jsonData;
    protected $helper;

    public function __construct(
        Context $context,
        \Webkul\BlogManager\Model\BlogFactory $blogFactory,
        \Webkul\BlogManager\Helper\Data $helper,
        \Magento\Framework\Json\Helper\Data $jsonData
    ) {
        $this->blogFactory = $blogFactory;
        $this->helper = $helper;
        $this->jsonData = $jsonData;
        parent::__construct($context);
    }

    public function execute()
    {
        $blogId = $this->getRequest()->getParam('id');
        $customerId = $this->helper->getCustomerId();

        $isAuthorised = $this->blogFactory->create()
            ->getCollection()
            ->addFieldToFilter(
                'user_id',
                $customerId
            )
            ->addFieldToFilter(
                'entity_id',
                $blogId
            )
            ->getSize();

        if (!$isAuthorised) {
            $msg = __('You are not authorised to delete this blog.');
            $success = 0;

        } else {
            $model = $this->blogFactory->create()->load($blogId);
            $model->delete();
            $msg = __('You have successfully deleted the blog.');
            $success = 1;
        }
        
        $this->getResponse()->setHeader('Content-type', 'application/javascript');
        $this->getResponse()->setBody(
            $this->jsonData->jsonEncode(
                [
                    'success' => $success,
                    'message' => $msg
                ]
            )
        );
    }
}

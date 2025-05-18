<?php

namespace Webkul\BlogManager\Controller\Manage;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends AbstractAccount
{
    public $resultPageFactory;
    public $blogFactory;
    public $messageManager;
    protected $helper;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Webkul\BlogManager\Model\BlogFactory $blogFactory,
        \Webkul\BlogManager\Helper\Data $helper,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->blogFactory = $blogFactory;
        $this->helper = $helper;
        $this->messageManager = $messageManager;
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
            $this->messageManager->addErrorMessage(__('You are not authorised to edit this blog.'));
            return $this->resultRedirectFactory->create()->setPath('blog/manage');
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Edit Blog'));
        $layout = $resultPage->getLayout();
        return $resultPage;
    }
}

<?php

namespace Webkul\BlogManager\Controller\Manage;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Message\ManagerInterface;

class Save extends AbstractAccount
{
    protected $blogFactory;
    protected $messageManager;
    protected $helper;

    public function __construct(
        Context $context,
        \Webkul\BlogManager\Model\BlogFactory $blogFactory,
        \Webkul\BlogManager\Helper\Data $helper,
        ManagerInterface $messageManager
    ) {
        $this->blogFactory = $blogFactory;
        parent::__construct($context);
        $this->helper = $helper;
        $this->messageManager = $messageManager;
    }
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $customerId = $this->helper->getCustomerId();

        if (isset($data['id']) && $data['id']) {
            $isAuthorised = $this->blogFactory->create()
                ->getCollection()
                ->addFieldToFilter(
                    'user_id',
                    $customerId
                )
                ->addFieldToFilter(
                    'entity_id',
                    $data['id']
                )
                ->getSize();

            if (!$isAuthorised) {
                $this->messageManager->addErrorMessage(__('You are not authorised to edit this blog.'));
                return $this->resultRedirectFactory->create()->setPath('blog/manage');

            } else {
                $model = $this->blogFactory->create()->load($data['id']);
                $model->setTitle($data['title'])
                    ->setContent($data['content'])
                    ->save();
                $this->messageManager->addSuccessMessage(__('You have updated the blog successfully.'));
            }
            
        } else {
            $model = $this->blogFactory->create();
            $model->setData($data);
            $model->setUserId($customerId);
            $model->save();
            $this->messageManager->addSuccessMessage(__('Blog saved successfully.'));
        }
        return $this->resultRedirectFactory->create()->setPath('blog/manage');
    }
}
// __('text') - translated text
<?php

namespace Perspective\HomeworkDatabase\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Action
{
    /**
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend((__('Edit Record')));

        return $resultPage;
    }
}
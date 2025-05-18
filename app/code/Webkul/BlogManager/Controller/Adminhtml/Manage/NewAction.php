<?php

namespace Webkul\BlogManager\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;

class NewAction extends Action
{
    public function execute()
    {
        $this->_forward('edit');
    }
    
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_BlogManager::add');
    }
}

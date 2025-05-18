<?php

namespace Webkul\BlogManager\Block\Adminhtml\Blog;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Webkul_BlogManager';
        $this->_controller = 'adminhtml_blog';
        parent::_construct();
        $this->buttonList->remove('delete');
    }
}

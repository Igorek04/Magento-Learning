<?php

namespace Webkul\BlogManager\Block\Adminhtml\Blog\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct(
            $context,
            $jsonEncoder,
            $authSession,
            $data
        );
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('blog_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Blog Data'));
    }

    protected function _prepareLayout()
    {
        $this->addTab(
            'main',
            [
                'label' => __('Blog Data'),
                'content' => $this->getLayout()->createBlock(
                    'Webkul\BlogManager\Block\Adminhtml\Blog\Edit\Tab\Main'
                )->toHtml(),
                'active' => true
            ]
        );

        $this->addTab(
            'status',
            [
                'label' => __('Blog Status'),
                'content' => $this->getLayout()->createBlock(
                    'Webkul\BlogManager\Block\Adminhtml\Blog\Edit\Tab\Status'
                )->toHtml()
            ]
        );

        $this->addTab(
            'related_products',
            [
                'label' => __('Related Products'),
                'content' => $this->getLayout()->createBlock(
                    'Webkul\BlogManager\Block\Adminhtml\Blog\Edit\Tab\RelatedProducts'
                )->toHtml()
            ]
        );
        
        return parent::_prepareLayout();
    }
}

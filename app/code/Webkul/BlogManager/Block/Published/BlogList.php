<?php

namespace Webkul\BlogManager\Block\Published;

class BlogList extends \Magento\Framework\View\Element\Template
{
    public $blogCollection;
    public $blogList;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\BlogManager\Model\ResourceModel\Blog\CollectionFactory $blogCollection,
        \Webkul\BlogManager\Helper\Data $helper,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->blogCollection = $blogCollection;
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $data);
    }

    public function getCollection()
    {
        if (!$this->blogList) {
            $collection = $this->blogCollection->create();
            $collection->addFieldToFilter('status', 1);
            $collection->setOrder('created_at', 'DESC');
            $this->blogList = $collection;
        }
        return $this->blogList;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getCollection()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'blogmanager.publishedblog.pager'
            )
                ->setCollection(
                    $this->getCollection()
                );
            $this->setChild('pager', $pager);
            $this->getCollection()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    
    public function getAuthor($userId)
    {
        if ($userId) {
            $customer = $this->customerFactory->create()->load($userId);
            if ($customer && $customer->getId()) {
                return $customer->getName();
            }
        }

        return __('Admin');
    }

    public function getFormattedDate($date)
    {
        return $this->helper->getFormattedDate($date);
    }
}

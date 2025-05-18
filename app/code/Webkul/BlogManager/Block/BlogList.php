<?php

namespace Webkul\BlogManager\Block;

class BlogList extends \Magento\Framework\View\Element\Template
{
    protected $blogCollection;
    protected $statuses;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\BlogManager\Model\ResourceModel\Blog\CollectionFactory $blogCollection,
        \Webkul\BlogManager\Helper\Data $helper,
        \Webkul\BlogManager\Model\Blog\Status $blogStatus,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        array $data = []
    ) {
        $this->blogCollection = $blogCollection;
        $this->helper = $helper;
        $this->blogStatus = $blogStatus;
        $this->date = $date;
        parent::__construct($context, $data);
    }
    public function getBlogs()
    {
        $customerId = $this->helper->getCustomerId();
        $collection = $this->blogCollection->create();
        $collection->addFieldToFilter('user_id', $customerId)
            ->setOrder('updated_at', 'DESC');
        return $collection;
    }

    public function getStatuses()
    {
        $statuses = [];
        foreach ($this->blogStatus->toOptionArray() as $status) {
            $statuses[$status['value']] = $status['label'];
        }
        return $statuses;
    }
    
    public function getFormattedDate($date)
    {
        return $this->date->date($date)->format('d/m/y H:i');
    }
}


















/*
namespace Webkul\BlogManager\Block;

use Magento\Customer\Model\SessionFactory;

class BlogList extends \Magento\Framework\View\Element\Template
{
    protected $blogCollection;
    protected $customerSession;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\BlogManager\Model\ResourceModel\Blog\CollectionFactory $blogCollection,
        SessionFactory $customerSession,
        array $data = []
    ) {
        $this->blogCollection = $blogCollection;
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getBlogs()
    {
        $customerId = $this->customerSession->create()->getCustomer()->getId();

        $collection = $this->blogCollection->create();

        $collection->addFieldToFilter('user_id', ['eq'=>$customerId])
                   ->setOrder('updated_at', 'DESC');

        return $collection;
    }
}

/*
->addFieldToFilter('user_id', $customerId)
=
->addFieldToFilter('user_id', ['eq'=>$customerId])



[“eq” => $equalValue]
[“neq” => $notEqualValue]
[“like” => $likeValue]
[“in” => [$inValues]]
[“nin” => [$notInValues]]
[“notnull” => $valueIsNotNull]
[“null” => $valueIsNull]
[“gt” => $greaterValue]
[“lt” => $lessValue]
[“gteq” => $greaterOrEqualValue]
[“lteq” => $lessOrEqualValue]
[“from” => $fromValue, “to” => $toValue]
*/
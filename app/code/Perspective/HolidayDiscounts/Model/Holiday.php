<?php

namespace Perspective\HolidayDiscounts\Model;

use Magento\Framework\Model\AbstractModel;
use Perspective\HolidayDiscounts\Model\ResourceModel\Holiday as HolidayResourceModel;
use Perspective\HolidayDiscounts\Model\ResourceModel\Holiday\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class Holiday extends AbstractModel
{
    /**
     * @var CollectionFactory 
     */
    protected $holidayCollectionFactory;

    /**
     * @param CollectionFactory $holidayCollectionFactory
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        CollectionFactory $holidayCollectionFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->holidayCollectionFactory = $holidayCollectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize model
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init(HolidayResourceModel::class);
    }

    /**
     * Validate holiday data before saving.
     *
     * @return $this
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        parent::beforeSave();

        $startDate = date('Y-m-d', strtotime($this->getData('start_date')));
        $endDate = date('Y-m-d', strtotime($this->getData('end_date')));
        $currentId = (int)$this->getId();

        // Start Date < End Date
        if ($startDate >= $endDate) {
            throw new LocalizedException(__('Start Date must be earlier than End Date.'));
        }

        //date validation with another holiday dates
        $collection = $this->holidayCollectionFactory->create();
        $collection->addFieldToFilter('start_date', ['lt' => $endDate]);
        $collection->addFieldToFilter('end_date', ['gt' => $startDate]);
        if ($currentId) {
            $collection->addFieldToFilter('holiday_id', ['neq' => $currentId]);
            }
        if ($collection->getSize() > 0) {
            throw new LocalizedException(__('The selected date conflicts with another holiday date.'));
        }

        //start_date =< current_day(exact date) <= end_date 
        $currentDay = $this->getData('current_day');
        if ($currentDay) {
            $exactDate = date('Y-m-d', strtotime($currentDay));
            if ($exactDate < $startDate || $exactDate > $endDate) {
                throw new LocalizedException(
                    __('Current Day must be within the selected holiday period.')
                );
            }
        }
        return $this;
    }
}


<?php

namespace Perspective\HolidayDiscounts\Plugin;

use Perspective\HolidayDiscounts\Helper\Validation as ValidationHelper;

class AddHolidayAttributeToCollection
{
    /**
     * @var ValidationHelper
     */
    protected $validationHelper;

    /**
     * @param ValidationHelper $validationHelper
     */
    public function __construct(
        ValidationHelper $validationHelper
    ) {
        $this->validationHelper = $validationHelper;
    }

    /**
     * Add 'is_holiday' attribute to collection select if the module is enabled
     * and the collection is not already loaded.
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $collection
     *
     * @return array|null
     */
    public function beforeLoad(\Magento\Catalog\Model\ResourceModel\Product\Collection $collection)
    {
        if (!$this->validationHelper->isModuleEnabled()) {
            return [];
        }
        
        if ($collection->isLoaded()) {
            return [];
        }

        $collection->addAttributeToSelect('is_holiday');
        return [];
    }
}

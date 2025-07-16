<?php
namespace Perspective\HolidayDiscounts\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Perspective\HolidayDiscounts\Model\ResourceModel\Holiday\CollectionFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Data extends AbstractHelper
{
    /**
     * @var CatalogHelper 
     */
    protected $catalogHelper;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var TimezoneInterface
     */
    protected $timezone;

    protected $currentDate = null;
    protected $currentHoliday = null;

    /**
     * @param CatalogHelper $catalogHelper
     * @param CollectionFactory $collectionFactory
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        CatalogHelper $catalogHelper,
        CollectionFactory $collectionFactory,
        TimezoneInterface $timezone,
        ) {
        $this->catalogHelper = $catalogHelper;
        $this->collectionFactory = $collectionFactory;
        $this->timezone = $timezone;
    }

    /**
     * Return current product from catalog helper.
     *
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getCurrentProduct()
    {
        return $this->catalogHelper->getProduct();
    }

    /**
     * Return current active holiday.
     *
     * @return \Perspective\HolidayDiscounts\Model\Holiday|null
     */
    public function getCurrentHoliday()
    {
        if ($this->currentHoliday === null) {
            $currentDate = $this->getCurrentDate();

            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('start_date', ['lteq' => $currentDate])
                       ->addFieldToFilter('end_date', ['gteq' => $currentDate]);

            $this->currentHoliday = $collection->getFirstItem();
        }
        return $this->currentHoliday;
    }

    /**
     * Return current store date in Y-m-d format.
     *
     * @return string
     */
    public function getCurrentDate()
    {
        if ($this->currentDate === null) {
            $this->currentDate = $this->timezone->date()->format('Y-m-d');
        }
        return $this->currentDate;
    }
}
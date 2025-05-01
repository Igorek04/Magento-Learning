<?php

namespace Perspective\HomeworkDatabase\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Perspective\HomeworkDatabase\Model\ConsultationFactory;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation\Collection;

class GetDataByCustomer implements ArgumentInterface
{
    /**
     * @var ConsultationFactory
     */
    private $consultationFactory;

    /**
     * Constructor
     *
     * @param ConsultationFactory $consultationFactory
     */
    public function __construct(
        ConsultationFactory $consultationFactory
    ) {
        $this->consultationFactory = $consultationFactory;
    }

    /**
     * Get Collection Filtered By Customer, Datetime
     *
     * @param int $customerId
     * @param string $datetimeMax
     * @param string $datetimeMin
     * @return Collection
     */
    public function getFilteredConsultations(
        int $customerId,
        string $datetimeMin,
        string $datetimeMax
        ) {
        $collection = $this->consultationFactory->create()->getCollection();
    
        $collection->addFieldToFilter('customer_id', $customerId);
        $collection->addFieldToFilter('consultation_datetime', ['gteq' => $datetimeMin]);
        $collection->addFieldToFilter('consultation_datetime', ['lteq' => $datetimeMax]);

        return $collection;
    }
}

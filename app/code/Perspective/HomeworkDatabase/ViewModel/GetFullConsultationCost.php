<?php

namespace Perspective\HomeworkDatabase\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Perspective\HomeworkDatabase\Model\ConsultationFactory;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation\Collection;

class GetFullConsultationCost implements ArgumentInterface
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
     * Get Collection of Consultations.
     *
     * @param string $titleFilter
     * @return Collection
     */
    public function getConsultationCollection()
    {
        $collection = $this->consultationFactory->create()->getCollection();
    
        return $collection;
    }
}

<?php

namespace Perspective\HomeworkDatabase\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Perspective\HomeworkDatabase\Model\ConsultationFactory;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation\Collection;

class GetDataByTitleFilter implements ArgumentInterface
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
     * Get Filtered By Title Collection of Consultations.
     *
     * @param string $titleFilter
     * @return Collection
     */
    public function getConsultationsByTitle(string $titleFilter)
    {
        $collection = $this->consultationFactory->create()->getCollection();
    
        $collection->addFieldToFilter('title', ['like' => '%' . $titleFilter . '%']);

        return $collection;
    }
}

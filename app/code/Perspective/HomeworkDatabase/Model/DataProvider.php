<?php
 
namespace Perspective\HomeworkDatabase\Model;
 
use Magento\Ui\DataProvider\AbstractDataProvider;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation\CollectionFactory;
 
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;
 
    // @codingStandardsIgnoreStart
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $consultationCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $consultationCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    // @codingStandardsIgnoreEnd

    /**
     * @return array
     */
    public function getData()
    {
 
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
 
        $items = $this->collection->getItems();
 
        foreach ($items as $consultation) {
            $this->loadedData[$consultation->getConsultationId()] = $consultation->getData();
        }
        return $this->loadedData;
    }
}

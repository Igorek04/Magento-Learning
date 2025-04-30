<?php

namespace Perspective\HomeworkDatabase\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Perspective\HomeworkDatabase\Model\ConsultationFactory;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation;

class AddMoreData implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ConsultationFactory
     */
    private $consultationFactory;

    /**
     * @var Consultation
     */
    private $consultationResource;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * Сonstructor.
     *
     * @param ConsultationFactory $consultationFactory
     * @param Consultation $сonsultationResource
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ConsultationFactory $consultationFactory,
        Consultation $consultationResource,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->consultationFactory = $consultationFactory;
        $this->consultationResource = $consultationResource;
        $this->moduleDataSetup=$moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     * 
     * Adds 2 new consultation records to the 'consultation' table.
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();
    
        $consultation = $this->consultationFactory->create();
        $lastConsultation = $consultation->getCollection()
                                         ->setOrder('consultation_datetime', 'DESC')
                                         ->setPageSize(1)
                                         ->load()
                                         ->getFirstItem();
    
        $startDatetime = new \DateTime($lastConsultation->getData('consultation_datetime'));
    
        for ($i = 1; $i <= 2; $i++) {
            $consultation = $this->consultationFactory->create();
            
            $consultation->setConsultationDatetime($startDatetime->format('Y-m-d H:i:s'));
            $startDatetime->modify('+12 hours');
    
            $consultation->addData([
                'title' => 'Consultation ' . ($lastConsultation->getData('consultation_id') + 1 + $i),
                'duration_hours' => 1.5 + $i,
                'consultation_datetime' => $startDatetime->format('Y-m-d H:i:s'),
                'customer_id' => 1,
                'discount_rate' => 0.05 * $i,
                'price_per_hour' => 10 * $i
            ]);
    
            $this->consultationResource->save($consultation);
        }
    
        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getVersion()
    {
        return '1.0.3';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
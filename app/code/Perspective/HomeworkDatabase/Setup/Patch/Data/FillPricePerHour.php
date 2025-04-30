<?php

namespace Perspective\HomeworkDatabase\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Perspective\HomeworkDatabase\Model\ConsultationFactory;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation;

class FillPricePerHour implements DataPatchInterface, PatchVersionInterface
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
     * Adds data to the 'price_per_hour' column.
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        for ($i = 1; $i <= 5; $i++) {
            $consultation = $this->consultationFactory->create();
            $consultation->load($i);
            $consultation->addData(['price_per_hour' => $i * 10 ]);
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
        return '1.0.2';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
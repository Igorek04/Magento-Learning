<?php

namespace Perspective\HomeworkDatabase\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Perspective\HomeworkDatabase\Model\ConsultationFactory;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation;

class AddData implements DataPatchInterface, PatchVersionInterface
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
     * Adds multiple consultation records into the consultation table using a data patch
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $startDatetime = new \DateTime('2025-05-01 08:00:00');

        for ($i = 0; $i < 5; $i++) 
        {
            $consultation = $this->consultationFactory->create();

            $consultation->addData([
                'title' => $i < 2 ? 'Consultation Repeat' : 'Consultation Unique ' . $i,
                'duration_hours' => 1.5 + $i,
                'consultation_datetime' => $startDatetime->format('Y-m-d H:i:s'),
                'customer_id' => $i + 1, // customer_id 1-5
                'discount_rate' => 0.05 * $i
            ]);

            $this->consultationResource->save($consultation);

            $startDatetime->modify('+12 hours');
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
        return '1.0.1';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
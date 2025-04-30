<?php

namespace Perspective\Datapatch\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Perspective\Datapatch\Model\ContactdetailsFactory;
use Perspective\Datapatch\Model\ResourceModel\Contactdetails;

/**
 * Adds a data row into the contact_details table using a data patch
 */
class AddData implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ContactdetailsFactory
     */
    private $contactDetailsFactory;

    /**
     * @var Contactdetails
     */
    private $contactDetailsResource;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * AddData constructor.
     *
     * @param ContactdetailsFactory $contactDetailsFactory
     * @param Contactdetails $contactDetailsResource
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ContactdetailsFactory $contactDetailsFactory,
        Contactdetails $contactDetailsResource,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->contactDetailsFactory = $contactDetailsFactory;
        $this->contactDetailsResource = $contactDetailsResource;
        $this->moduleDataSetup=$moduleDataSetup;
    }

    /**
     * Apply the data patch to insert a contact record
     *
     * @return void
     */
    public function apply()
    {
        //Install data row into contact_details table
        $this->moduleDataSetup->startSetup();
        $contactDTO=$this->contactDetailsFactory->create();
        $contactDTO->setCustomerName('John')
                   ->setCustomerEmail('andrew@email.com')
                   ->setContactNo('9988884444');
        $this->contactDetailsResource->save($contactDTO);
        $this->moduleDataSetup->endSetup();
    }

    /**
     * Specify dependencies of this patch
     *
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Return patch version
     *
     * @return string
     */
    public static function getVersion()
    {
        return '1.0.1';
    }

    /**
     * Return patch aliases
     *
     * @return array
     */
    public function getAliases()
    {
        return [];
    }
}
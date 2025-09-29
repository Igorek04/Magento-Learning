<?php
namespace Perspective\HomeworkWholesalers\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Api\Data\GroupInterfaceFactory;

class CreateWholesalerGroups implements DataPatchInterface
{
    /**
     * @var GroupRepositoryInterface 
     */
    protected $groupRepository;

    /**
     * @var GroupInterfaceFactory
     */
    protected $groupFactory;

    /**
     * @param GroupRepositoryInterface $groupRepository
     * @param GroupInterfaceFactory $groupFactory
     */
    public function __construct(
        GroupRepositoryInterface $groupRepository,
        GroupInterfaceFactory $groupFactory,
    ) {
        $this->groupRepository = $groupRepository;
        $this->groupFactory = $groupFactory;
    }
    
    /**
     * Create customer group by code
     *
     * @param string $code
     */
    private function createGroup(string $code)
    {
        $group = $this->groupFactory->create();
        $group->setCode($code);
        $group->setTaxClassId(\Magento\Customer\Model\ResourceModel\GroupRepository::DEFAULT_TAX_CLASS_ID);
        $this->groupRepository->save($group);
    }

    public function apply()
    {
        //create wholesalers group programmatically
        $this->createGroup('homework_standart_wholesaler');
        $this->createGroup('homework_large_wholesaler');
    }
    
    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}

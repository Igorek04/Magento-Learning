<?php
namespace Perspective\HomeworkWholesalers\Model\Config\Backend;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\RequestInterface;

class GroupsValidation extends \Magento\Framework\App\Config\Value
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        RequestInterface $request,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        parent::__construct(
            $context,
            $registry,
            $scopeConfig,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * Checks that the same customer group is not selected for both "standart" and "large" wholesalers
     *
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        //get current selected group path
        $currentPath = $this->getPath();
        //define selected group different from current
        if (strpos($currentPath, 'standart_wholesaler/group') !== false) {
            $otherGroup = 'large_wholesaler';
        } else {
            $otherGroup = 'standart_wholesaler';
        }

        //get current saved group id
        $currentValue = $this->getValue();
        //get different from current saved group id
        $otherValue = $this->request->getParam('groups', [])[$otherGroup]['fields']['group']['value'];

        //if current group same as other -> error
        //(excluding when both groups not selected)
        if ($currentValue !== '' && $otherValue !== '' && $currentValue == $otherValue) {
            throw new LocalizedException(
                __('The same customer group cannot be selected for both wholesalers.')
            );
        }
        return parent::beforeSave();
    }
}

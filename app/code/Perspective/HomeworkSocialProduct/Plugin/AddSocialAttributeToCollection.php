<?php

namespace Perspective\HomeworkSocialProduct\Plugin;

use Perspective\HomeworkSocialProduct\Helper\Social as SocialHelper;

class AddSocialAttributeToCollection
{
    /**
     * @var SocialHelper
     */
    protected $socialHelper;

    /**
     * @param SocialHelper $socialHelper
     */
    public function __construct(
        SocialHelper $socialHelper
    ) {
        $this->socialHelper = $socialHelper;
    }

    /**
     * Before plugin for product collection load method.
     *
     * Adds 'is_social' custom attribute to the collection select if the module is enabled
     * and the collection is not already loaded.
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $collection
     *
     * @return array|null
     */
    public function beforeLoad(\Magento\Catalog\Model\ResourceModel\Product\Collection $collection)
    {
        if (!$this->socialHelper->isModuleEnabled()) {
            return [];
        }
        
        if ($collection->isLoaded()) {
            return [];
        }

        $collection->addAttributeToSelect('is_social');

        return [];
    }
}

<?php

namespace Perspective\HomeworkSocialProduct\Plugin;

use Perspective\HomeworkSocialProduct\Helper\Social as SocialHelper;
use Magento\Framework\App\Request\Http;

class SocialLabel
{
    /**
     * @var SocialHelper
     */
    protected $socialHelper;

    /**
     * @var Http 
     */
    protected $request;

    /**
     * @param SocialHelper $socialHelper
     */
    public function __construct(
        SocialHelper $socialHelper,
        Http $request
    ) {
        $this->socialHelper = $socialHelper;
        $this->request = $request;
    }

    /**
     * After plugin for getName method of product
     *
     * Adds " - SOCIAL!!!" suffix to product name only on category (catalog) pages
     * if the social module is enabled and the product has enabled social attribute.
     *
     * @param \Magento\Catalog\Model\Product $product The product instance
     * @param string $name The original product name
     * @return string Modified product name with optional " - SOCIAL!!!" suffix
     */
    public function afterGetName(\Magento\Catalog\Model\Product $product, $name)
    {
        //Check if the module is disabled
        if(!$this->socialHelper->isModuleEnabled()) {
            return $name;
        }

        //Check if the current page is a catalog category page
        if ($this->request->getFullActionName() !== 'catalog_category_view') {
            return $name;
        }

        //Check if the social attribute is enabled for this product
        if($this->socialHelper->isSocialAttributeEnabled($product)) {
            $name .= " - SOCIAL!!!";
        }

        return $name;
    }
}

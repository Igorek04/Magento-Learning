<?php declare(strict_types=1);
namespace Perspective\CustomCheckout\Block\Checkout\LayoutProcessor;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class UpdateAddressSortOrder implements LayoutProcessorInterface
{
    public function process($jsLayout): array
    {
        foreach (
            $jsLayout['components']['checkout']['children']
                     ['steps']['children']['billing-step']
                     ['children']['payment']['children']
                     ['payments-list']['children'] as &$paymentMethod
        ) {
            $fields = &$paymentMethod['children']['form-fields']['children'];
            if ($fields === null) {
                continue;
            }
            //edit sort order of payment address from layoutProcessor
            $fields['city']['sortOrder'] = '2';
            $fields['postcode']['sortOrder'] = '250';
        }
        return $jsLayout;
    }
}

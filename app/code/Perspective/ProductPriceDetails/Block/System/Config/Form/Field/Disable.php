<?php
namespace Perspective\ProductPriceDetails\Block\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Perspective\ProductPriceDetails\Helper\ConfigData;
use Magento\Backend\Block\Template\Context;

class Disable extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var ConfigData 
     */
    protected $configHelper;

    /**
     * @param Context $context
     * @param ConfigData $configHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigData $configHelper,
        array $data = []
    ) {
        $this->configHelper = $configHelper;
        parent::__construct($context, $data);
    }

    /**
     * Deactivate field in config if module is disabled.
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $enabled = $this->configHelper->getConfigValue('enabled');
        
        if (!$enabled) {
            $element->setDisabled('disabled');
        }

        return $element->getElementHtml();
    }
}
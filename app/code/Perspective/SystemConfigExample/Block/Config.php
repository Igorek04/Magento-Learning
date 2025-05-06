<?php

namespace Perspective\SystemConfigExample\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Perspective\SystemConfigExample\Helper\Data;

class Config extends Template
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param Context $context
     * @param Data $helper
     */
    public function __construct(Context $context, Data $helper)
    {
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->helper->isEnabled();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->helper->getTitle();
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->helper->getSecret();
    }

    /**
     * @return string
     */
    public function getOption()
    {
        return $this->helper->getOption();
    }
}

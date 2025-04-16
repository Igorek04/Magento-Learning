<?php

declare(strict_types=1);

namespace Perspective\ProductTools\Controller\ProductStockInfo;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Controller for displaying product stock information.
 */
class Index implements ActionInterface
{
    /**
     * @var PageFactory
     */
    private PageFactory $pageFactory;

    /**
     * @param PageFactory $pageFactory
     */
    public function __construct(PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

    /**
     * Execute controller action.
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        return $this->pageFactory->create();
    }
}

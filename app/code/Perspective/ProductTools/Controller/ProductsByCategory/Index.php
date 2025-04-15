<?php
declare(strict_types=1);

namespace Perspective\ProductTools\Controller\ProductsByCategory;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Controller for displaying products by category.
 */
class Index implements ActionInterface
{
    /**
     * @var PageFactory
     */
    private PageFactory $pageFactory;

    /**
     * Constructor.
     *
     * @param PageFactory $pageFactory Result page factory.
     */
    public function __construct(PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

    /**
     * Executes the controller action.
     *
     * @return ResultInterface The result page.
     */
    public function execute(): ResultInterface
    {
        return $this->pageFactory->create();
    }
}
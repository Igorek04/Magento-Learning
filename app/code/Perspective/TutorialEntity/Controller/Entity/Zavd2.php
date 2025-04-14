<?php
namespace Perspective\TutorialEntity\Controller\Entity;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;

class Zavd2 implements ActionInterface
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * Конструктор
     *
     * @param PageFactory $pageFactory
     */
    public function __construct(PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
    }

    /**
     * Execute метод контроллера
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        return $this->_pageFactory->create();
    }
}
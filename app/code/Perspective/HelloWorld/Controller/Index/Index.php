<?php
namespace Perspective\HelloWorld\Controller\Index;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
/**
* Class Index
* @package Perspective\HelloWorld\Controller\Index

*/
class Index implements ActionInterface
{
/**
* @var \Magento\Framework\View\Result\PageFactory
*/
protected $_pageFactory;
public function __construct(
PageFactory $pageFactory
)
{
$this->_pageFactory = $pageFactory;
}
public function execute()
{
return $this->_pageFactory->create();
}
}
<?php
 
namespace Perspective\HolidayDiscounts\Controller\Adminhtml\Index;
 
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Perspective\HolidayDiscounts\Model\ResourceModel\Holiday\CollectionFactory;
 
class MassDelete extends Action
{
    /**
     * @var Filter
     */
    protected $filter;
 
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
 
    /**
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
 
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
 
        $collection = $this->filter->getCollection($this->collectionFactory->create());
 
        $collectionSize = $collection->getSize();
 
        foreach ($collection as $item) {
            $item->delete();
        }
 
        $this->messageManager->addSuccessMessage(__('A total of %1 element(s) have been deleted.', $collectionSize));
 
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}

<?php

namespace Perspective\HolidayDiscounts\Controller\Adminhtml\Index;
 
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Perspective\HolidayDiscounts\Model\Holiday as HolidayModel;
use Perspective\HolidayDiscounts\Model\ResourceModel\Holiday as HolidayResourceModel;

class Delete extends Action
{
    /**
     * @var HolidayModel
     */
    protected $holidayModel;
 
    /**
     * @var HolidayResourceModel
     */
    protected $holidayResourceModel;

    /**
     * @param Context $context
     * @param HolidayModel $consultationModel
     * @param HolidayResourceModel $consultationResourceModel
     */
    public function __construct(
        Context $context,
        HolidayModel $holidayModel,
        HolidayResourceModel $holidayResourceModel
    ) {
        parent::__construct($context);
        $this->holidayModel = $holidayModel;
        $this->holidayResourceModel = $holidayResourceModel;
    }
 
    /**
     * @return  boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Perspective_HolidayDiscounts::index_delete');
    }
 
    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('holiday_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->holidayModel;
                $this->holidayResourceModel->load($model, $id);
                $this->holidayResourceModel->delete($model);

                $this->messageManager->addSuccessMessage(__('Record deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('Record does not exist.'));
        return $resultRedirect->setPath('*/*/');
    }
}

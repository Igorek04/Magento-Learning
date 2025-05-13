<?php

namespace Perspective\HomeworkDatabase\Controller\Adminhtml\Index;
 
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Perspective\HomeworkDatabase\Model\Consultation as ConsultationModel;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation as ConsultationResourceModel;

class Delete extends Action
{
    /**
     * @var ConsultationModel
     */
    protected $consultationModel;
 
    /**
     * @var ConsultationResourceModel
     */
    protected $consultationResourceModel;

    /**
     * @param Context $context
     * @param ConsultationModel $consultationModel
     * @param ConsultationResourceModel $consultationResourceModel
     */
    public function __construct(
        Context $context,
        ConsultationModel $consultationModel,
        ConsultationResourceModel $consultationResourceModel
    ) {
        parent::__construct($context);
        $this->consultationModel = $consultationModel;
        $this->consultationResourceModel = $consultationResourceModel;
    }
 
    /**
     * @return  boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Perspective_HomeworkDatabase::index_delete');
    }
 
    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('consultation_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->consultationModel;
                $this->consultationResourceModel->load($model, $id);
                $this->consultationResourceModel->delete($model);

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

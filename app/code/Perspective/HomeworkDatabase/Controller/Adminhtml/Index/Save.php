<?php
 
namespace Perspective\HomeworkDatabase\Controller\Adminhtml\Index;
 
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Perspective\HomeworkDatabase\Model\Consultation as ConsultationModel;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation as ConsultationResourceModel;
 
class Save extends Action
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
     * @var Session
     */
    protected $adminsession;
 
    /**
     * @param Context $context
     * @param ConsultationModel $consultationModel
     * @param ConsultationResourceModel $consultationResourceModel
     * @param Session $adminsession
     */
     public function __construct(
        Context $context,
        ConsultationModel $consultationModel,
        Session $adminsession,
        ConsultationResourceModel $consultationResourceModel
    ) {
        parent::__construct($context);
        $this->consultationModel = $consultationModel;
        $this->adminsession = $adminsession;
        $this->consultationResourceModel = $consultationResourceModel;
    }
 
    /**
     * Save consultation record action
     *
     * @return Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
 
        if ($data) {
            $consultation_id = $this->getRequest()->getParam('consultation_id');

            $model = $this->consultationModel;

            if ($consultation_id) {
                $this->consultationResourceModel->load($model, $consultation_id);
            }
 
            $model->setData($data);
 
            try {
                $this->consultationResourceModel->save($model);
                $this->messageManager->addSuccessMessage(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath('*/*/edit', ['consultation_id' => $model->getId(), '_current' => true]);
                    }
                }
 
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the data.'));
            }
 
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['consultation_id' => $this->getRequest()->getParam('consultation_id')]);
        }
 
        return $resultRedirect->setPath('*/*/');
    }
}

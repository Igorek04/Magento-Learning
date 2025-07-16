<?php

namespace Perspective\HolidayDiscounts\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Session;
use Perspective\HolidayDiscounts\Model\Holiday as HolidayModel;
use Perspective\HolidayDiscounts\Model\ResourceModel\Holiday as HolidayResourceModel;

class Save extends \Magento\Backend\App\Action
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
     * @var Session
     */
    protected $adminsession;

    /**
     * @param Action\Context $context
     * @param HolidayModel $holidayModel
     * @param HolidayResourceModel $holidayResourceModel
     * @param Session $adminsession
     */
    public function __construct(
        Action\Context $context,
        HolidayModel $holidayModel,
        HolidayResourceModel $holidayResourceModel,
        Session $adminsession
    ) {
        parent::__construct($context);
        $this->holidayModel = $holidayModel;
        $this->holidayResourceModel = $holidayResourceModel;
        $this->adminsession = $adminsession;
    }

    /**
     * Save holiday record action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $holiday_id = $this->getRequest()->getParam('holiday_id');
            if ($holiday_id) {
                $this->holidayResourceModel->load($this->holidayModel, $holiday_id);
            }

            $model = $this->holidayModel->setData($data);

            try {
                $this->holidayResourceModel->save($model);
                $this->messageManager->addSuccessMessage(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath('*/*/edit', ['holiday_id' => $this->holidayModel->getHolidayId(), '_current' => true]);
                    }
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the data.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['holiday_id' => $this->getRequest()->getParam('holiday_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}

<?php
 
namespace Perspective\UiExample\Controller\Adminhtml\Index;
 
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Perspective\UiExample\Model\Blog;
 
class Save extends Action
{
    /**
     * @var Blog
     */
    protected $uiExamplemodel;
 
    /**
     * @var Session
     */
    protected $adminsession;
 
    /**
     * @param Context $context
     * @param Blog $uiExamplemodel
     * @param Session $adminsession
     */
    public function __construct(
        Context $context,
        Blog $uiExamplemodel,
        Session $adminsession
    ) {
        parent::__construct($context);
        $this->uiExamplemodel = $uiExamplemodel;
        $this->adminsession = $adminsession;
    }
 
    /**
     * Save blog record action
     *
     * @return Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
 
        $resultRedirect = $this->resultRedirectFactory->create();
 
        if ($data) {
            $blog_id = $this->getRequest()->getParam('blog_id');
            if ($blog_id) {
                $this->uiExamplemodel->load($blog_id);
            }
 
            $this->uiExamplemodel->setData($data);
 
            try {
                $this->uiExamplemodel->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath('*/*/edit', ['blog_id' => $this->uiExamplemodel->getBlogId(), '_current' => true]);
                    }
                }
 
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
 
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['blog_id' => $this->getRequest()->getParam('blog_id')]);
        }
 
        return $resultRedirect->setPath('*/*/');
    }
}

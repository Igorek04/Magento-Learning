<?php

namespace Perspective\UiExample\Controller\Adminhtml\Index;
 
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Perspective\UiExample\Model\Blog;
 
class Delete extends Action
{
    /**
     * @var Blog
     */
    protected $modelBlog;
 
    /**
     * @param Context $context
     * @param Blog $blogFactory
     */
    public function __construct(
        Context $context,
        Blog $blogFactory
    ) {
        parent::__construct($context);
        $this->modelBlog = $blogFactory;
    }
 
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Perspective_UiExample::index_delete');
    }
 
    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('blog_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->modelBlog;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Record deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Record does not exist.'));
        return $resultRedirect->setPath('*/*/');
    }
}

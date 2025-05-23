<?php
 
namespace Perspective\HomeworkDatabase\Block\Adminhtml\Index\Edit\Button;
 
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
 
class Delete extends Generic implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    protected $context;
 
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }
 
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $consultation_id = $this->context->getRequest()->getParam('consultation_id');
 
        if ($consultation_id) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }
 
    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        $consultation_id = $this->context->getRequest()->getParam('consultation_id');
        return $this->getUrl('*/*/delete', ['consultation_id' => $consultation_id]);
    }
}

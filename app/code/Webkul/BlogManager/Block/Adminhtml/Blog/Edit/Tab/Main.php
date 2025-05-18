<?php

namespace Webkul\BlogManager\Block\Adminhtml\Blog\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Webkul\BlogManager\Model\Blog\Status $blogStatus,
        array $data = []
    ) {
        $this->blogStatus = $blogStatus;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('blog_data');

        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('blogmanager_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Edit Blog'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField('entity_id', 'hidden', ['name' =>
        'entity_id']);

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'id' => 'title',
                'title' => __('Title'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        
        $fieldset->addField(
            'content',
            'textarea',
            [
                'name' => 'content',
                'label' => __('Content'),
                'id' => 'content',
                'title' => __('Content'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}

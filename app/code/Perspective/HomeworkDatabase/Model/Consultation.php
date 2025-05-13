<?php

namespace Perspective\HomeworkDatabase\Model;

use Magento\Framework\Model\AbstractModel;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation as ConsultationResourceModel;

class Consultation extends AbstractModel
{
    /**
     * Initialize model
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ConsultationResourceModel::class);
    }
}

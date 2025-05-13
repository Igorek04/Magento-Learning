<?php

namespace Perspective\HomeworkDatabase\Model\ResourceModel\Consultation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Perspective\HomeworkDatabase\Model\ResourceModel\Consultation as ConsultationResourceModel;
use Perspective\HomeworkDatabase\Model\Consultation as ConsultationModel;

class Collection extends AbstractCollection
{
    /**
    * Initialize resource collection
    *
    * @return void
    */
    protected function _construct()
    {
        $this->_init(ConsultationModel::class, ConsultationResourceModel::class);
    }
}
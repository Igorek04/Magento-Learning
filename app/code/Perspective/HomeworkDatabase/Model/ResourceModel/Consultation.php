<?php

namespace Perspective\HomeworkDatabase\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Consultation extends AbstractDb
{
    /**
     * Initialize resource model
     * 
     * @return void
     */
    public function _construct() 
    {
        $this->_init('consultation', 'consultation_id');
    }
}
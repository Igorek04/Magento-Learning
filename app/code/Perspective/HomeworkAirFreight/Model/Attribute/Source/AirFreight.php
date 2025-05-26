<?php
namespace Perspective\HomeworkAirFreight\Model\Attribute\Source;

class AirFreight extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Get all options(static add option list)
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('None'), 'value' => 'none'],
                ['label' => __('Balloon'), 'value' => 'balloon'],
                ['label' => __('Charter plane'), 'value' => 'charterPlane'],
                ['label' => __('High-speed plane'), 'value' => 'hsPlane'],
                ['label' => __('Spaceship'), 'value' => 'spaceship'],
            ];
        }
        return $this->_options;
    }
}

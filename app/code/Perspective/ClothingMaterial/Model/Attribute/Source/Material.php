<?php
namespace Perspective\ClothingMaterial\Model\Attribute\Source;

class Material extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Get all options(static add option list)
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('Cotton'), 'value' => 'cotton'],
                ['label' => __('Leather'), 'value' => 'leather'],
                ['label' => __('Silk'), 'value' => 'silk'],
                ['label' => __('Denim'), 'value' => 'denim'],
                ['label' => __('Fur'), 'value' => 'fur'],
                ['label' => __('Wool'), 'value' => 'wool'],
            ];
        }
        return $this->_options;
    }
}

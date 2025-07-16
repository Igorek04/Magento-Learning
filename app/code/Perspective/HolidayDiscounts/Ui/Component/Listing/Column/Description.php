<?php

namespace Perspective\HolidayDiscounts\Ui\Component\Listing\Column;

class Description extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Cut description to 30 characters for admin grid.
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {

            $fieldName = 'description';
            
            foreach ($dataSource['data']['items'] as &$item) {

                if (empty($item[$fieldName])) {
                    $item[$fieldName] = '';
                    continue;
                }

                $item[$fieldName] = substr(
                    $item[$fieldName],
                    0,
                    30
                ) . '...';
            }
        }
        return $dataSource;
    }
}
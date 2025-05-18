<?php

namespace Webkul\BlogManager\Ui\Component\Listing\Columns;

class Content extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {

            $fieldName = 'content';
            
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$fieldName] = substr(
                    $item[$fieldName],
                    0,
                    20
                ) . '...';
            }
        }
        return $dataSource;
    }
}

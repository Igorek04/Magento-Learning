<?php
namespace Perspective\ViewModelExamp\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class ViewModelExamp implements ArgumentInterface
{
    public function sayHello()
    {
        return __('Learn Magento 2 ViewModelExamp Layout Commit 3');
    }
}
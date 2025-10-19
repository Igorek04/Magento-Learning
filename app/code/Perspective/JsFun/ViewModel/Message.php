<?php
declare(strict_types=1);
namespace Perspective\JsFun\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
// Define an implementation of ArgumentInterface returning the desired output.
class Message implements ArgumentInterface
{
    public function getMessage()
    {
        return __(str_shuffle('Declarative test'));
    }
}

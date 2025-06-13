<?php

namespace Perspective\ObserverPractice\Controller\Index;

class TestEvent implements \Magento\Framework\App\ActionInterface
{
    private $response;
    private $eventManager;

    public function __construct(
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\Event\ManagerInterface $eventManager
    ) {
        $this->response = $response;
        $this->eventManager = $eventManager;
    }

    public function execute()
    {
        $textDisplay = new \Magento\Framework\DataObject(array('text' => 'Perspective'));

        $this->eventManager->dispatch('perspective_display_text', ['mp_text' => $textDisplay]);

        $this->response->setBody($textDisplay->getText());
        return $this->response;
    }
}

<?php

namespace Perspective\CronExample\Cron;

class ExampleTask
{
    /**
     * Test cron job for message in var/log/magento.cron.log
     */
    public function execute()
    {
        echo "Test cron executed at: " . date('Y-m-d H:i:s') . "\n";
        return $this;
    }
}
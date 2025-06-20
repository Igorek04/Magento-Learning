<?php

namespace Perspective\CronCacheCleaner\Cron;

use Magento\Framework\App\Cache\TypeListInterface;

class CacheCleaner
{
    /**
     * @var TypeListInterface
     */
    protected $cacheTypeList;

    /**
     * @param TypeListInterface $cacheTypeList
     */
    public function __construct(TypeListInterface $cacheTypeList) 
    {
        $this->cacheTypeList = $cacheTypeList;
    }

    /**
     * Clean invalidated cache
     */
    public function execute()
    {
        // Get invalidated cache types
        $invalidatedCacheList = $this->cacheTypeList->getInvalidated();

        // Clear invalidated cache types
        foreach($invalidatedCacheList as $invalidatedCache) {
          $this->cacheTypeList->cleanType($invalidatedCache);
        }

        // Log result
        echo "[" . date('Y-m-d H:i:s') . "] " . "Invalidated cache cleaned." . "\n";
        return $this;
    }
}
<?php

namespace Perspective\CreateAdminGrid\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Post extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'perspective_createadmingrid_post';

    protected $_cacheTag = self::CACHE_TAG;

    protected $_eventPrefix = 'perspective_createadmingrid_post';

    protected function _construct()
    {
        $this->_init(\Perspective\CreateAdminGrid\Model\ResourceModel\Post::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}

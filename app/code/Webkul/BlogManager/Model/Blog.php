<?php

namespace Webkul\BlogManager\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Blog extends AbstractModel implements IdentityInterface
{
    const NOROUTE_ENTITY_ID = 'no-route';
    const ENTITY_ID = 'entity_id';
    const CACHE_TAG = 'webkul_blogmanager_blog';

    protected $_cacheTag = 'webkul_blogmanager_blog';
    protected $_eventPrefix = 'webkul_blogmanager_blog';

    public function _construct()
    {
        $this->_init(\Webkul\BlogManager\Model\ResourceModel\Blog::class);
    }

    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRoute();
        }
        return parent::load($id, $field);
    }

    public function noRoute()
    {
        return $this->load(
            self::NOROUTE_ENTITY_ID,
            $this->getIdFieldName()
        );
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
}

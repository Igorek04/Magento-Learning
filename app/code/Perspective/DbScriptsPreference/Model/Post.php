<?php

namespace Perspective\DbScriptsPreference\Model;

class Post extends \Perspective\DbScripts\Model\Post
{
    /**
     * @return string
     */
    public function prefName()
    {
        $name = $this->getData('name');
        return 'magento2_' . $name;
    }

    /**
     * @return string
     */
    public function shortUrl()
    {
        $id = $this->getData('post_id');
        $name = $this->getData('name');
        
        $editedName = strtolower(trim($name));
        $editedName = preg_replace('/[^a-z0-9\s]/', '', $editedName);
        $editedName = preg_replace('/\s+/', '-', $editedName);

    return 'id-' . $id . '-name-' . $editedName;
    }

}
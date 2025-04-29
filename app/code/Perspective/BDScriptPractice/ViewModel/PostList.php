<?php

namespace Perspective\BDScriptPractice\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Perspective\BDScriptPractice\Model\PostFactory;

class PostList implements ArgumentInterface
{
    /**
     * @var PostFactory
     */
    private $_postFactory;

    /**
     * Constructor
     *
     * @param PostFactory $postFactory
     */
    public function __construct(
        PostFactory $postFactory
    ) {
        $this->_postFactory = $postFactory;
    }

    public function getPostCollection() {
        $post = $this->_postFactory->create();
        $collection = $post->getCollection();

        return $collection;
    }
}

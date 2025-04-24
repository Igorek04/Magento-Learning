<?php
namespace Perspective\CookiePractice\Controller\Cookie;

use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\Raw;

class AddCookie implements ActionInterface
{
    /**
     * @var CookieManagerInterface
     */
    private $customCookieManager;

    /**
     * @var CookieMetadataFactory
     */
    private $customCookieMetadataFactory;

    /**
     * @var RawFactory
     */
    private $resultRawFactory;

    /**
     * Constructor.
     *
     * @param CookieManagerInterface $customCookieManager
     * @param CookieMetadataFactory $customCookieMetadataFactory
     * @param RawFactory $resultRawFactory
     */
    public function __construct(
        CookieManagerInterface $customCookieManager,
        CookieMetadataFactory $customCookieMetadataFactory,
        RawFactory $resultRawFactory
        ) {
        $this->customCookieManager = $customCookieManager;
        $this->customCookieMetadataFactory = $customCookieMetadataFactory;
        $this->resultRawFactory = $resultRawFactory;
    }

    /**
    * Set a custom cookie.
    *
    * @return Raw
    */
    public function execute()
    {
        $customCookieMetadata = $this->customCookieMetadataFactory->createPublicCookieMetadata();
        $customCookieMetadata->setDurationOneYear();
        $customCookieMetadata->setPath('/');
        $customCookieMetadata->setHttpOnly(false);

        $this->customCookieManager->setPublicCookie(
            'a_custom_cookie',
            'Cookie_Value',
            $customCookieMetadata
        );

        return $this->resultRawFactory->create()->setContents("Custom cookie added");
    }
}
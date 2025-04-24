<?php
namespace Perspective\CookiePractice\Controller\Cookie;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;

/**
 * Controller for delete custom cookie.
 */
class DeleteCookie implements ActionInterface
{
    /**
     * @var CookieManagerInterface
     */
    private $cookieManager;

    /**
     * @var RawFactory
     */
    private $resultRawFactory;

    /**
     * @var CookieMetadataFactory
     */
    private $cookieMetadataFactory;

    /**
     * Constructor.
     *
     * @param RawFactory $resultRawFactory
     * @param CookieManagerInterface $cookieManager
     * @param CookieMetadataFactory $cookieMetadataFactory
     */
    public function __construct(
        CookieManagerInterface $cookieManager,
        RawFactory $resultRawFactory,
        CookieMetadataFactory $cookieMetadataFactory
        ) {
        $this->cookieManager = $cookieManager;
        $this->resultRawFactory = $resultRawFactory;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
    }

    /**
     * Delete custom cookie.
     *
     * @return Raw
     */
    public function execute()
    {
        $cookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata();
        
        $this->cookieManager->deleteCookie('a_custom_cookie', $cookieMetadata);

        return $this->resultRawFactory->create()->setContents("Custom cookie deleted");
    }
}
<?php
namespace Perspective\CookiePractice\Controller\Cookie;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Controller\Result\Raw;

/**
 * Controller for reading cookies.
 */
class ReadCookie implements ActionInterface
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
     * Constructor.
     *
     * @param CookieManagerInterface $cookieManager
     * @param RawFactory $resultRawFactory
     */
    public function __construct(
        CookieManagerInterface $cookieManager,
        RawFactory $resultRawFactory
        ) {
        $this->cookieManager = $cookieManager;
        $this->resultRawFactory = $resultRawFactory;
    }

    /**
     * Read and show cookies.
     *
     * @return Raw
     */
    public function execute()
    {
        // Get cookie values
        $cookieValue1 = $this->cookieManager->getCookie('a_custom_cookie'); // Custom cookie
        $cookieValue2 = $this->cookieManager->getCookie('section_data_ids'); // Cookie from cart page

        $content = "<h2>Set, Read and Delete Cookie Data</h2>" .
           "Custom cookie value: " . $cookieValue1 . "<br>" .
           "Added to cart item cookie value: " . $cookieValue2 . "<br>";

        return $this->resultRawFactory->create()->setContents($content);

    }
}

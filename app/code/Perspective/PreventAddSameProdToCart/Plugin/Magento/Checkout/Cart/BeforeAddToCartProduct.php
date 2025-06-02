<?php
    
namespace Perspective\PreventAddSameProdToCart\Plugin\Magento\Checkout\Cart;

use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session;
use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Session\Proxy as SessionProxy;
use Magento\Framework\Message\ManagerInterface;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\UrlInterface;

class BeforeAddToCartProduct
{
    /**
     * @var ManagerInterface 
     */
    private $messageManager;

    /**
     * @var SessionProxy 
     */
    private $cartSession;

    /**
     * @var Configurable 
     */
    private $configurableProduct;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var Session 
     */
    private $session;

    /**
     * @param Configurable $configurableProduct
     * @param ManagerInterface $messageManager
     * @param SessionProxy $cartSession
     * @param UrlInterface $url
     * @param Session $session
     */
    public function __construct(
        Configurable $configurableProduct,
        ManagerInterface $messageManager,
        SessionProxy $cartSession,
        UrlInterface $url,
        Session $session
        ) {
        $this->messageManager = $messageManager;
        $this->cartSession = $cartSession;
        $this->configurableProduct = $configurableProduct;
        $this->url = $url;
        $this->session = $session;
    }

    /**
     * Prevent adding the same product to the cart twice.
     *
     * @param Cart $subject
     * @param Product|mixed $productInfo
     * @param array|null $requestInfo
     * 
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeAddProduct(Cart $subject, $productInfo, $requestInfo=null)
    {
        $enableProductCartControl=true;

        $product = null;
        $parentProduct=null;

        if ($productInfo instanceof Product)
        {
            $product = $productInfo;
            if (!$product->getId())
            {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __("This product wasn't found. Verify the product and try again.")
                );
            }
        }

        if ($product)
        {
            // For Simple Product
            if ($product->getTypeId()==='configurable')
            {
                if (isset($requestInfo['super_attribute']))
                {
                    $parentProduct=$product;
                    $childProduct = $this->configurableProduct->getProductByAttributes($requestInfo['super_attribute'] ,$product);
                    // change $product to child
                    $product=$childProduct;
                }
            }
            if ($product && $enableProductCartControl)
            {
                    // For check product is in cart or not
                    if($this->cartSession->getQuote()->hasProductId($product->getId()))
                    {
                        // Redirection to the cart page
                        $this->session->setRedirectUrl($this->url->getUrl('checkout/cart/index'));
                        throw new \Magento\Framework\Exception\LocalizedException(
                            __("[x] This product is already in the cart. Testing, testing : ". $product->getSku())
                        );
                    }
             }
        }
        return [$productInfo, $requestInfo];
    }

    /**
     * Get request for product add to cart procedure
     *
     * @param \Magento\Framework\DataObject|int|array $requestInfo
     * 
     * @return \Magento\Framework\DataObject
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function _getProductRequest($requestInfo)
    {
        if ($requestInfo instanceof \Magento\Framework\DataObject)
        {
            $request = $requestInfo;
        }
        elseif (is_numeric($requestInfo))
        {
            $request = new \Magento\Framework\DataObject(['qty' => $requestInfo]);
        }
        elseif (is_array($requestInfo))
        {
            $request = new \Magento\Framework\DataObject($requestInfo);
        }
        else
        {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('We found an invalid request for adding product to quote.')
            );
        }
        return $request;
    }
}
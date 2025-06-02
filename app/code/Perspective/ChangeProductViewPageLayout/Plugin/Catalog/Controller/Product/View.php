<?php

namespace Perspective\ChangeProductViewPageLayout\Plugin\Catalog\Controller\Product;

use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class View
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param RequestInterface $request
     * @param ProductRepositoryInterface $productRepository
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        RequestInterface $request,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager
    ) {
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
    }

    /**
     * @param \Magento\Catalog\Controller\Product\View $subject
     * @param \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\ResultInterface $resultPage
     * 
     * @return \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\ResultInterface
     */
    public function afterExecute(\Magento\Catalog\Controller\Product\View $subject, $resultPage)
    {
        if ($resultPage instanceof ResultInterface) {
            $productId = (int) $this->request->getParam('id');

            if ($productId) {
                try {
                    /** @var \Magento\Catalog\Api\Data\ProductInterface|\Magento\Catalog\Model\Product $product */
                    $product = $this->productRepository->getById($productId, false, $this->storeManager->getStore()->getId());

                    if ($product->getFinalPrice() <= 50) {

                        /** @var \Magento\Framework\View\Result\Page $resultPage */
                        $pageConfig = $resultPage->getConfig();
                        $pageConfig->setPageLayout('2columns-right'); //Set your page layout here.
                    }
                } catch (NoSuchEntityException $e) {
                    // Add you exception message here.
                }
            }
        }
        return $resultPage;
    }
}

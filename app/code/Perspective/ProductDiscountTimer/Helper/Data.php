<?php
namespace Perspective\ProductDiscountTimer\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Customer\Model\Session;
use Magento\CatalogRule\Model\ResourceModel\Rule as RuleResourceModel;
use Magento\CatalogRule\Model\Rule as RuleModel;
use Magento\CatalogRule\Api\CatalogRuleRepositoryInterface;

class Data extends AbstractHelper
{
    /**
     * @var CatalogHelper 
     */
    protected $catalogHelper;

    /**
     * @var RuleResourceModel 
     */
    protected $ruleResource;

    /**
     * @var TimezoneInterface 
     */
    protected $localeDate;

    /**
     * @var StoreManagerInterface 
     */
    protected $storeManager;

    /**
     * @var Session 
     */
    protected $customerSession;

    /**
     * @var RuleModel 
     */
    protected $ruleModel;

    /**
     * @var CatalogRuleRepositoryInterface
     */
    protected $catalogRuleRepository;

    /**
     * @param CatalogHelper $catalogHelper
     * @param RuleResourceModel $ruleResource
     * @param TimezoneInterface $localeDate
     * @param StoreManagerInterface $storeManager
     * @param Session $customerSession
     * @param RuleModel $ruleModel
     * @param CatalogRuleRepositoryInterface $catalogRuleRepository
     */
    public function __construct(
        CatalogHelper $catalogHelper,
        RuleResourceModel $ruleResource,
        TimezoneInterface $localeDate,
        StoreManagerInterface $storeManager,
        Session $customerSession,
        RuleModel $ruleModel,
        CatalogRuleRepositoryInterface $catalogRuleRepository,
        ) {
        $this->catalogHelper = $catalogHelper;
        $this->ruleResource = $ruleResource;
        $this->localeDate = $localeDate;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->ruleModel = $ruleModel;
        $this->catalogRuleRepository = $catalogRuleRepository;
    }

    /**
     * Return current product from catalog helper.
     *
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getCurrentProduct()
    {
        return $this->catalogHelper->getProduct();
    }

    /**
     * Get catalog price rules for current product.
     *
     * @return array|null
     */
    public function getCatalogRulesFromProduct()
    {
        $product = $this->getCurrentProduct();

        $productId = $product->getId();
        $storeId = $product->getStoreId();
        $websiteId = $this->storeManager->getStore($storeId)->getWebsiteId();

        $date = $this->localeDate->scopeTimeStamp($storeId);
        $customerGroupId = $this->customerSession->getCustomerGroupId();

        return $this->ruleResource->getRulesFromProduct($date, $websiteId, $customerGroupId, $productId);
    }


    /**
     * Check if catalog rule gives better discount than special price.
     *
     * @return bool
     */
    public function isCatalogRuleCheaperThanSpecial()
    {
        $product = $this->getCurrentProduct();

        $catalogRulePrice = $this->ruleModel->calcProductPriceRule($product, $product->getPrice());
        $specialPrice = $product->getSpecialPrice();

        if (!$specialPrice || $product->getPrice() == $specialPrice) {
            return true; 
        }

        return $catalogRulePrice < $specialPrice;
    }

    /**
     * Get special price info for current product.
     *
     * @return array|null
     */
    public function getSpecialPriceData()
    {
        $product = $this->getCurrentProduct();
        $specialPrice = $product->getSpecialPrice();

        if (!$specialPrice) {
            return null;
        }
        if ($product->getPrice() == $specialPrice) {
            return null;
        }

        return [
            'rule_name' => 'special price',
            'rule_type' => 'special',
            'action_operator' => 'special',
            'action_amount' => $specialPrice,
            'to_time' => $product->getSpecialToDate()
        ];
    }

    /**
     * Get all discount rules (catalog + special) for product.
     *
     * @return array
     */
    public function getUnifiedDiscountRules()
    {
        $catalogRules = $this->getCatalogRulesFromProduct();
        $specialRule = $this->getSpecialPriceData();

        $rules = [];
        foreach ($catalogRules as $rule) {
            $rules[] = [
                'rule_name' => $this->getCatalogRuleName($rule['rule_id']),
                'rule_type' => 'catalog_rule',
                'action_operator' => $rule['action_operator'],
                'action_amount' => $rule['action_amount'],
                'to_time' => $this->formatDate($rule['to_time'])
            ];
        }
        if ($specialRule !== null){
            $rules[] = [
                'rule_name' => $specialRule['rule_name'],
                'rule_type' => $specialRule['rule_type'],
                'action_operator' => $specialRule['action_operator'],
                'action_amount' => $specialRule['action_amount'],
                'to_time' => $this->formatDate($specialRule['to_time'])
            ];
        }
        
        if (!empty($rules) && is_array($rules)) {
            usort($rules, [$this, 'sortByToTimeAsc']);
        } else {
            $rules = [];
        }
        return $rules;
    }
    
    public function formatDate($date)
    {
        if ($date === null) {
            return null;
        }
        if (is_numeric($date)) {
            $date = (new \DateTime())->setTimestamp((int)$date);
        }

        return $this->localeDate->formatDateTime(
            $date,
            \IntlDateFormatter::SHORT,
            \IntlDateFormatter::SHORT,
            null,
            null,
            'yyyy-MM-dd HH:mm:ss'
        );
    }
    
    /**
     * Sort discount rules array by end date.
     */
    public function sortByToTimeAsc(array $a, array $b)
    {
        $timeA = !empty($a['to_time']) ? strtotime($a['to_time']) : PHP_INT_MAX;
        $timeB = !empty($b['to_time']) ? strtotime($b['to_time']) : PHP_INT_MAX;

        return $timeA <=> $timeB;
    }

    /**
     * Get name of catalog rule by ID.
     *
     * @param int $ruleId
     * 
     * @return string
     */
    public function getCatalogRuleName($ruleId)
    {
        $rule = $this->catalogRuleRepository->get($ruleId);

        return $rule->getName();
    }
}
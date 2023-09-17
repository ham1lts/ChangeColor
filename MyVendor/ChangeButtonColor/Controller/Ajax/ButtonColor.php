<?php

namespace MyVendor\ChangeButtonColor\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

class ButtonColor extends Action
{

    const CONFIG_PATH = 'vendor/changecolor/hexa';

    /** @var ScopeConfigInterface */
    protected $_scopeConfig;

    /** @var JsonFactory */
    protected $_resultJsonFactory;

    /** @var StoreManagerInterface */
    protected $_storeManager;

    public function __construct(
        Context               $context,
        JsonFactory           $resultJsonFactory,
        ScopeConfigInterface  $scopeConfig,
        StoreManagerInterface $storeManager
    )
    {
        $this->_scopeConfig = $scopeConfig;
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->getRequest()->isAjax()) {
            $result = $this->_resultJsonFactory->create();
            $storeId = (string) $this->_storeManager->getStore()->getId();

            $hexaConfig = $this->_scopeConfig->getValue(self::CONFIG_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORES, $storeId) ?? "#000000";
            $result->setData(['button_color' => $hexaConfig]);

            return $result;
        }

        return false;
    }
}

<?php

require_once 'Mage/Catalog/controllers/ProductController.php';

class HubCo_LinkBySKU_ProductController extends Mage_Catalog_ProductController
{
    public function viewAction()
    {
        // Get initial data from request
        $categoryId =  Mage::app()->getRequest()->getParam('category', false);
        $productId  =  Mage::app()->getRequest()->getParam('id');
        $specifyOptions = Mage::app()->getRequest()->getParam('options');

        $productSku  = Mage::app()->getRequest()->getParam('sku');

        if ($productSku) {
          $cProd = Mage::getModel('catalog/product');
          $productId = $cProd->getIdBySku($productSku);

          $product = $cProd->load($productId);
          $productURL = $product->getProductUrl();

          Mage::app()->getResponse()
          ->setRedirect($productURL, 301)
          ->sendResponse();
        }

        // Prepare helper and params
        $viewHelper = Mage::helper('catalog/product_view');

        $params = new Varien_Object();
        $params->setCategoryId($categoryId);
        $params->setSpecifyOptions($specifyOptions);

        // Render page
        try {
          $viewHelper->prepareAndRender($productId, $this, $params);
        } catch (Exception $e) {
          if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
            if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
              $this->_redirect('');
            } elseif (!$this->getResponse()->isRedirect()) {
              $this->_forward('noRoute');
            }
          } else {
            Mage::logException($e);
            $this->_forward('noRoute');
          }
        }
    }

    public function goToURLAction() {
      echo "Hiiii";
      exit;
    }
}

?>
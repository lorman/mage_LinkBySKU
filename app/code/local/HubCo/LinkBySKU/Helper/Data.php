<?php
class HubCo_LinkBySKU_Helper_Data extends Mage_Core_Helper_Abstract
{
  public function getMageUrl($productSku) {
    if (!empty($productSku)) {
      $cProd = Mage::getModel('catalog/product');
      $productId = $cProd->getIdBySku($productSku);
      $product = $cProd->load($productId);
  #    $productURL = $product->getProductUrl();
      $productURL = $product->getUrlPath();
      return "/".$productURL;
    } else {
      return false;
    }
  }
}
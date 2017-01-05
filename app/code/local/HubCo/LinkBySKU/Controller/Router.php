<?php
class HubCo_LinkBySKU_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract
{
    public function initControllerRouters($observer)
    {
        $front = $observer->getEvent()->getFront();
        $front->addRouter('HubCo_LinkBySKU', $this);
        return $this;
    }
    public function match(Zend_Controller_Request_Http $request)
    {
      $helper = Mage::helper('hubco_linkbysku');

      if (!Mage::isInstalled()) {
          Mage::app()->getFrontController()->getResponse()
              ->setRedirect(Mage::getUrl('install'))
              ->sendResponse();
          exit;
      }

      $urlKey = $request->getPathInfo();

      $redirect = Mage::getModel('hubco_linkbysku/redirects')->getRedirectURL($urlKey);

      if (!$redirect) {
        return false;
      } else {
        if (empty($redirect['new_link'])) {
          $magentoUrl = $helper->getMageUrl($redirect['sku']);

          // update the path in db
          Mage::getModel('hubco_linkbysku/redirects')->setRedirectURL($redirect['sku'],$magentoUrl);

        } else {
          if (!empty($redirect['sku'])) {
            $magentoUrl = $redirect['new_link'];
          }
        }

        $location = 'Location: '.$magentoUrl;
        header($location,TRUE,301);
        exit;
      }
      return false;
    }
}
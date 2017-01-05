<?php
class HubCo_LinkBySKU_Model_Redirects
    extends Mage_Core_Model_Abstract
{
    var $readCon;
    var $writeCon;
    var $resource;
    var $local;

    protected function _construct()
    {
        /**
         * This tells Magento where the related resource model can be found.
         *
         * For a resource model, Magento will use the standard model alias -
         * in this case 'hubco_linkbysku' - and look in
         * config.xml for a child node <resourceModel/>. This will be the
         * location that Magento will look for a model when
         * Mage::getResourceModel() is called - in our case,
         * HubCo_LinkBySKU_Model_Resource.
         */
        parent::_construct();
        $this->_init('hubco_linkbysku/redirects');
        $this->resource = Mage::getSingleton ( 'core/resource' );

        // Retrieve the read connection
        $this->readCon = $this->resource->getConnection ( 'core_read' );

        // Retrieve the write connection
        $this->writeCon = $this->resource->getConnection ( 'core_write' );
        // $this->local = dirname(__FILE__)."/../data/custom.csv";
    }

    public function getRedirectURL($old_url) {
      $resource = Mage::getSingleton('core/resource');
      // Retrieve the read connection
      $readConnection = $resource->getConnection('core_read');
      $tableName = $resource->getTableName('hubco_linkbysku/redirects');

      $query = "SELECT * FROM `$tableName` WHERE old_link = '".$old_url."'";
      $return = $readConnection->fetchRow($query);

      return $return;
    }

    public function setRedirectURL($sku, $url) {
      $resource = Mage::getSingleton('core/resource');
      // Retrieve the read connection
      $writeConnection = $resource->getConnection('core_write');
      $tableName = $resource->getTableName('hubco_linkbysku/redirects');

      $query = "UPDATE `$tableName` SET new_link = '".$url."' WHERE sku = '".$sku."'";
      $writeConnection->query($query);

      return;
    }
}
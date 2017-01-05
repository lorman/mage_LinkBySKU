<?php
$this->startSetup ();
$table = new Varien_Db_Ddl_Table ();
$table->setName ( $this->getTable ( 'hubco_linkbysku/redirects' ) );
$table->addColumn(
    'old_link',
    Varien_Db_Ddl_Table::TYPE_VARCHAR, '255',
    array(
        'nullable'  => false,
    ),
    'Old Link'
);
$table->addColumn(
    'sku',
    Varien_Db_Ddl_Table::TYPE_TEXT, 64,
    array(
        'nullable'  => false,
    ),
    'SKU'
);
$table->addColumn(
    'new_link',
    Varien_Db_Ddl_Table::TYPE_VARCHAR, '255',
    array(
        'nullable'  => false,
    ),
    'New Link'
);
$table->addColumn(
    'type',
    Varien_Db_Ddl_Table::TYPE_INTEGER, 3,
    array(
        'nullable'  => false,
    ),
    'Reditect Type'
);
$table->setComment('Manual RawData Table');
$table->setOption ( 'type', 'InnoDB' );
$table->setOption ( 'charset', 'utf8' );
$this->getConnection()->createTable($table);

// add index
$tableName = $this->getTable('hubco_linkbysku/redirects');
//Check if the table already exists
if ($this->getConnection ()->isTableExists ( $tableName )) {
  $table = $this->getConnection ();
  $table->addIndex ( $this->getTable ( 'hubco_linkbysku/redirects' ), $this->getIdxName ( 'hubco_linkbysku/redirects', array (
      'old_link'
  ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
      'old_link'
  ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );
}

$this->endSetup ();
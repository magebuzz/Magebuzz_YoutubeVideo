<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/


class Magebuzz_Youtubevideo_Model_Mysql4_Youtubevideo extends Mage_Core_Model_Mysql4_Abstract
{
  public function _construct()
  {
    // Note that the youtubevideo_id refers to the key field in your database table.
    $this->_init('youtubevideo/youtubevideo', 'id');
  }

	public function lookupVideoId()
  {
    $adapter = $this->_getReadAdapter();

    $select  = $adapter->select()
      ->from($this->getTable('youtubevideo'), 'video_id');

    return $adapter->fetchCol($select);
  }
}
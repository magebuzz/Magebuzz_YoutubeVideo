<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/

class Magebuzz_Youtubevideo_Model_Mysql4_Youtubevideoproduct_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('youtubevideo/youtubevideoproduct');
    }
}
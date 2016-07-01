	<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 0;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('youtubevideo')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('youtubevideo')->__('Disabled')
        );
    }
}
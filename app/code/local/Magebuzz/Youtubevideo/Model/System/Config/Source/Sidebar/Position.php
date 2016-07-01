<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Model_System_Config_Source_Sidebar_Position {
	public function toOptionArray(){
		return array(
			array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Left Sidebar')),
			array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('Right Sidebar'))
		);
	}
}
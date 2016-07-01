<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Adminhtml_Youtubevideo_Import extends Mage_Adminhtml_Block_Widget_View_Container
{
	public function __construct() {
		parent::__construct();
		$this->_removeButton('edit');
	}

  public function getHeaderText() {
    return Mage::helper('youtubevideo')->__('Import videos');
  }
}
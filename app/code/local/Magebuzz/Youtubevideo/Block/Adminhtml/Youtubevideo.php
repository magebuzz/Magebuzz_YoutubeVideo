<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Adminhtml_Youtubevideo extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_youtubevideo';
    $this->_blockGroup = 'youtubevideo';
    $this->_headerText = Mage::helper('youtubevideo')->__('Video Manager');
	
		$this->_addButton('video_from_playlist', array(
			'label'     => Mage::helper('youtubevideo')->__('Import videos'),
			'onclick'   => 'setLocation(\'' . $this->_getImportUrl() .'\')',
			'class'     => 'add',
		));
    parent::__construct();
		$this->removeButton('add');
  }

  protected function _getImportUrl() {
		return $this->getUrl('*/*/import', array('_secure' => true));
  }
}
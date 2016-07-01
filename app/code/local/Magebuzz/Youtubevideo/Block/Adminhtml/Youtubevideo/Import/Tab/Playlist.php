<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Adminhtml_Youtubevideo_Import_Tab_Playlist extends Mage_Adminhtml_Block_Widget implements Mage_Adminhtml_Block_Widget_Tab_Interface {
  protected function _construct()  {
    parent::_construct();
    $this->setTemplate('youtubevideo/playlist.phtml');
  }

  public function getTabTitle() {
    return Mage::helper('youtubevideo')->__('From Playlist');
  }

  public function getTabLabel() {
    return Mage::helper('core')->__('From Playlist');
  }

  public function canShowTab() {
    return true;
  }

  public function isHidden() {
    return false;
  }
}
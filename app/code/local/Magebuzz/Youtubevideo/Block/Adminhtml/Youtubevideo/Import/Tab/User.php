<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Adminhtml_Youtubevideo_Import_Tab_User extends Mage_Adminhtml_Block_Widget implements Mage_Adminhtml_Block_Widget_Tab_Interface {
  protected function _construct()  {
    parent::_construct();
    $this->setTemplate('youtubevideo/user.phtml');
  }

  public function getTabTitle() {
    return Mage::helper('youtubevideo')->__('From User');
  }

  public function getTabLabel() {
    return Mage::helper('core')->__('From User');
  }

  public function canShowTab() {
    return true;
  }

  public function isHidden() {
    return false;
  }
}
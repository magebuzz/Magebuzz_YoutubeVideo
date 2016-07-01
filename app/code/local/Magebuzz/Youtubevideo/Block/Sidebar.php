<?php
  /*
  * Copyright (c) 2015 www.magebuzz.com
  */

class Magebuzz_Youtubevideo_Block_Sidebar extends Mage_Core_Block_Template {

  public function displayOnLeftSidebarBlock() {
    $block = $this->getParentBlock();
    if ($block) {

      if (Mage::getStoreConfig('youtubevideo/display/sidebar_position')== 1 && Mage::getStoreConfig('youtubevideo/display/sidebar_active')==1) {
        $sidebarBlock = $this->getLayout()->createBlock('youtubevideo/playlist')->setTemplate('youtubevideo/sidebar.phtml');
        $block->insert($sidebarBlock, '', false, 'youtubevideo-sidebar');
      }
    }
  }

  public function displayOnRightSidebarBlock() {
    $block = $this->getParentBlock();
    if ($block) {
      if (Mage::getStoreConfig('youtubevideo/display/sidebar_position')== 2  && Mage::getStoreConfig('youtubevideo/display/sidebar_active')==1) {
        $sidebarBlock = $this->getLayout()->createBlock('youtubevideo/playlist')->setTemplate('youtubevideo/sidebar.phtml');
        $block->insert($sidebarBlock, '', false, 'youtubevideo-sidebar');
      }
    }
  }
}
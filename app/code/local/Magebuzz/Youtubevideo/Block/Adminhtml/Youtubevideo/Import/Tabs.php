<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Adminhtml_Youtubevideo_Import_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
  public function __construct()
  {
    parent::__construct();
    $this->setTitle(Mage::helper('youtubevideo')->__('Import videos'));
  }
}
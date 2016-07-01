<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Adminhtml_Youtubevideo_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('youtubevideo_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('youtubevideo')->__('Video Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('youtubevideo')->__('Video Information'),
          'title'     => Mage::helper('youtubevideo')->__('Video Information'),
          'content'   => $this->getLayout()->createBlock('youtubevideo/adminhtml_youtubevideo_edit_tab_main')->toHtml(),
      ));  
      return parent::_beforeToHtml();
  }
}
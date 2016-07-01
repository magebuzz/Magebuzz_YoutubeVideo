<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Adminhtml_Youtubevideo_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form {

  protected function _prepareForm()  {
		$form = new Varien_Data_Form();
	  $form->setHtmlIdPrefix('youtubevideo_');
		$this->setForm($form);
		$fieldset = $form->addFieldset('youtubevideo_form', array('legend'=>Mage::helper('youtubevideo')->__('Video information')));	
	
		$fieldset->addField('is_featured', 'select', array(
			'label'     => Mage::helper('youtubevideo')->__('Featured Video'),
			'name'      => 'is_featured',
			'values'    => array(
				array(
					'value'     => 1,
					'label'     => Mage::helper('youtubevideo')->__('Yes'),
				),

				array(
					'value'     => 0,
					'label'     => Mage::helper('youtubevideo')->__('No'),
				),
			),
		));
		
		$fieldset->addField('show_on_home', 'select', array(
			'label'     => Mage::helper('youtubevideo')->__('Show on Home page'),
			'name'      => 'show_on_home',
			'values'    => array(
				array(
					'value'     => 1,
					'label'     => Mage::helper('youtubevideo')->__('Yes'),
				),

				array(
					'value'     => 0,
					'label'     => Mage::helper('youtubevideo')->__('No'),
				),
			),
		));
		$fieldset->addField('status', 'select', array(
				'label'     => Mage::helper('youtubevideo')->__('Status'),
				'name'      => 'status',
				'values'    => array(
						array(
								'value'     => 1,
								'label'     => Mage::helper('youtubevideo')->__('Enabled'),
						),

						array(
								'value'     => 0,
								'label'     => Mage::helper('youtubevideo')->__('Disabled'),
						),
				),
		));
		if ( Mage::getSingleton('adminhtml/session')->getYoutubevideoData() )	{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getYoutubevideoData());
			Mage::getSingleton('adminhtml/session')->setYoutubevideoData(null);
		} elseif ( Mage::registry('youtubevideo_data') ) {
			$form->setValues(Mage::registry('youtubevideo_data')->getData());
		}
		return parent::_prepareForm();
  }
}
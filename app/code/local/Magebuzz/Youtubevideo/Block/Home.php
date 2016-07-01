<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Home extends Mage_Core_Block_Template
{
	public function __construct() {			
		parent::__construct();			
		if(Mage::getStoreConfig('youtubevideo/display/show_on_homepage')){
			$this->setTemplate('youtubevideo/home_video.phtml');		
		}	
	}
	public function getHomeVideoId() {
		$collection = Mage::getModel('youtubevideo/youtubevideo')->getCollection();
		$collection->addFieldToFilter('status', '1');
		$collection->addFieldToFilter('show_on_home', '1');
		$collection->setOrder('update_time', 'desc');
		$collection->setPageSize(1);
		return $collection->getFirstItem()->getVideoId();
	}
}
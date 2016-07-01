<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/

class Magebuzz_Youtubevideo_Block_User extends Mage_Core_Block_Template {

	protected function _getVideoCollection() {
		$userId = $this->getUserId();
		if (!empty($userId)) {
			try {
				$youtube = new Zend_Gdata_YouTube();
				$youtube->setMajorProtocolVersion(2);
				$videos = $youtube->getUserUploads($userId);
	    	return $videos;
	    }
	    catch (Exception $e) {
	        Mage::helper('youtubevideo')->__("<p>Retriving videos errors</p>");
	    }
		} else {
			Mage::helper('youtubevideo')->__("<p>Missing 'user_id' parameter</p>");
		}
	}

	protected function _getBlockTitle() {
		$title = $this->getBlockTitle();
		return (is_null($title)) ? 'Youtube videos' : $title;
	}
}
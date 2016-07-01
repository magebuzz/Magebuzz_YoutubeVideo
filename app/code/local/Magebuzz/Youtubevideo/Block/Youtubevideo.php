<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/

class Magebuzz_Youtubevideo_Block_Youtubevideo extends Mage_Core_Block_Template
{
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}

	public function getVideoByUsername($username) {
		$yt = new Zend_Gdata_YouTube();
		$yt->setMajorProtocolVersion(2);
		$videoCollection = $yt->getuserUploads($username);
		return $videoCollection;
	}
	public function getVideoCollection() {
		$collection = Mage::getModel('youtubevideo/youtubevideo')->getCollection();
		$collection->addFieldToFilter('status', '1');
		return $collection;
	}
	public function getFeaturedVideo() {
		$collection = Mage::getModel('youtubevideo/youtubevideo')->getCollection();
		$collection->addFieldToFilter('status', '1');
		$collection->addFieldToFilter('is_featured', '1');
		$collection->setPageSize(3);
		return $collection;
	}
	public function getRandomVideoIdToDisplay() {
		$collection = Mage::getModel('youtubevideo/youtubevideo')->getCollection();
		$collection->addFieldToFilter('status', '1');
		$collection->addFieldToFilter('is_featured', '1');
		if($collection->count()){

		}else {
			$collection = $this->getVideoCollection();
		}
		$collection->getSelect()->order('rand()');
		$collection->setPageSize(1);
		return $collection->getFirstItem()->getVideoId();
	}
	public function getMainVideoId() {
		$mainVideoId = null;
		$video_id = $this->getRequest()->getParam('video_id');
		if($video_id) {
			$mainVideoId = $video_id;
		}else {
			$mainVideoId = $this->getRandomVideoIdToDisplay();
		}
		return $mainVideoId;
	}
}
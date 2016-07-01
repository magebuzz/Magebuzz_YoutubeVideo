<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Model_Youtubevideo extends Mage_Core_Model_Abstract
{
  public function _construct()
  {
      parent::_construct();
      $this->_init('youtubevideo/youtubevideo');
  }

	public function getVideoByYoutubeId($videoId) {
		$video = $this->getCollection()
			->addFieldToFilter('video_id', $videoId)
			->getFirstItem()
			->getData();		
		return $video;
	}

	public function loadVideoByYoutubeId($videoId) {
		$video = $this->getCollection()
			->addFieldToFilter('video_id', $videoId)
			->getFirstItem();
		return $video->getId();				
	}

	public function setVideo($_video) {
		$this->setVideoId($_video->getVideoId())
			// ->setPlaylistId($playlistId)
			->setVideoTitle($_video->getVideoTitle())
			->setVideoDescription($_video->getVideoDescription())
			->setVideoDuration($_video->getVideoDuration())
			->setVideoViewCount($_video->getVideoViewCount())
			->setIsFeatured(0)
			->setShowOnHome(0)
			->setStatus(1)
			->setCreatedTime(now())
			->setUpdateTime(now());
		if ($this->save()) return true;
		return false;
	}

	public function updateVideo($_video) {
		$this->setVideoTitle($_video->getVideoTitle())
			->setVideoDescription($_video->getVideoDescription())
			->setVideoDuration($_video->getVideoDuration())
			->setVideoViewCount($_video->getVideoViewCount())	
			->setUpdateTime(now());
		if ($this->save()) return true;
		return false;
	}

	public function getStatusByVideoId($video_id) {
		return $this->load($video_id,'video_id')->getStatus();
	}
}
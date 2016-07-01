<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/

class Magebuzz_Youtubevideo_Block_YoutubevideoProductPage extends Mage_Core_Block_Template
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
    $productId = Mage::registry('current_product')->getId();
    $videoProductCollection = Mage::getModel('youtubevideo/youtubevideoproduct')->getCollection()
      ->addFieldToFilter('product_id',$productId);
    $ids = array();
    if(count($videoProductCollection)) {
      foreach ($videoProductCollection as $videoProduct) {
        $ids[] = $videoProduct->getVideoId();
      }
    } else {
      return;
    }
 	  $collection = Mage::getModel('youtubevideo/youtubevideo')->getCollection();
		$collection->addFieldToFilter('status', '1')
     ->addFieldToFilter('id',$ids);
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
    $collection = $this->getVideoCollection();
    if($collection) {
      $collection->getSelect()->order('rand()');
  		$collection->setPageSize(1);
  		return $collection->getFirstItem()->getVideoId();
    }
		return;
	}
}